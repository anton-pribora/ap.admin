<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$data = <<<'PHP'
<?php

/* @var $this ApCode\Template\Template */
/* @var $record {$billetClass} */

$record = $this->argument(0);

if ($record->del()) {
    Alert('Запись отмечена как удалённая', 'warning');
}

?>
<div class="row widget">
  <div class="col-md-7">
    <?php echo Widget('{$widgetPath}.{$widgetName}', $record, $this->paramList())?>
  </div>
</div>

PHP;

$data = strtr($data, [
    '{$billetClass}' => $this->param('part.billet'),
    '{$widgetPath}'  => $this->param('widget.path'),
    '{$widgetName}'  => $this->param('widget.name')
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

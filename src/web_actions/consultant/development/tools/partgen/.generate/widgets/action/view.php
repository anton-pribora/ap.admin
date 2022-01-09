<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$billetClass = $this->param('part.billet');
$recordKey = $this->param('part.key');

$widgetPath = $this->param('widget.path');
$widgetName = $this->param('widget.name');
$widgetStore = $this->param('widget.store');

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

$record = $this->argument();

$enableEdit = $this->param('{$recordKey}.edit') || $this->param('{$recordKey}.{$widgetName}.edit');

$this->execute('../dist/view_form.php', $record, ['enableEdit' => $enableEdit] + $this->paramList());

Layout()->append('body.js.code', file_get_contents(__dir('../dist/store.js')));
Layout()->append('body.js.code', "store.state.{$widgetStore}.data = " . json_encode_array($this->include('encodeData.php')) . ';');
PHP;

$data = strtr($data, [
    '{$recordKey}' => $recordKey,
    '{$billetClass}' => $billetClass,
    '{$widgetName}' => $widgetName,
    '{$widgetStore}' => $widgetStore,
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

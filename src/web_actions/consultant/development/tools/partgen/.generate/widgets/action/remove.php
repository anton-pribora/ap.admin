<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

$record = $this->argument();

$editable = $this->param('{$recordKey}.edit') || $this->param('{$recordKey}.{$widgetName}.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на удаление', 'forbidden');
}

// {$repositoryClass}::drop($record);

$record->setDel(1);
$record->save();

$record->addHistory('Запись <b>' . $record->name() . '</b> была удалёна');

AddSessionAlert("{$textAfterRemove}");

ReturnJson(true);

PHP;

$data = strtr($data, [
    '{$billetClass}'     => $this->param('part.billet'),
    '{$repositoryClass}' => $this->param('part.repository'),
    '{$recordKey}'       => $this->param('part.key'),
    '{$widgetName}'      => $this->param('widget.name'),
    '{$textAfterRemove}' => $this->param('text.afterRemove')
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

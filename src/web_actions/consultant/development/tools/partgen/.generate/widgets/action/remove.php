<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$recordKey = $this->param('part.key');
$billetClass = $this->param('part.billet');
$repositoryClass = $this->param('part.repository');
$textAfterRemove = $this->param('text.afterRemove');

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

$record = $this->argument();

$data     = $this->param('widget_data', []);
$item     = $data['item'] ?? [];
$editable = $this->param('{$recordKey}.edit') || $this->param('{$recordKey}.{$widgetName}.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на удаление', 'forbidden');
}

{$repositoryClass}::drop($record);

AddSessionAlert("{$textAfterRemove}");

ReturnJson(true);

PHP;

$data = strtr($data, [
    '{$recordKey}' => $recordKey,
    '{$billetClass}' => $billetClass,
    '{$repositoryClass}' => $repositoryClass,
    '{$textAfterRemove}' => $textAfterRemove
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

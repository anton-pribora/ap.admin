<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

$record = $this->argument();

$data     = $this->param('widget_data', [])['data'] ?? [];
$editable = $this->param('{$recordKey}.edit') || $this->param('{$recordKey}.{$widgetName}.edit');

if (!$editable) {
    ReturnJsonError('У вас нет прав на удаление', 'forbidden');
}

$itemId = $data['id'] ?? '';

if (empty($itemId)) {
    ReturnJsonError('Не указан идентификатор элемента', 'null_id');
}

/*
$item = $record->items()->getById($itemId);

if (!$item) {
    ReturnJsonError('Не удалось найти элемент', 'bad_id');
}

$record->items()->remove($item);
*/

ReturnJson(true);

PHP;

$data = strtr($data, [
    '{$billetClass}' => $this->param('part.billet'),
    '{$recordKey}'   => $this->param('part.key'),
    '{$widgetName}'  => $this->param('widget.name'),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

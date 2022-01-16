<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$billetClass = $this->param('part.billet');
$recordKey   = $this->param('part.key');
$widgetName  = $this->param('widget.name');
$widgetStore = $this->param('widget.store');

$fields = $this->param('fields');

$updates = [];

foreach ($fields as ['prop' => $prop, 'title' => $title, 'setter' => $setter, 'edit' => $edit]) {
    if ($edit) {
        $updates[] = "\$item->{$setter}(\$data['{$prop}'] ?? '');  // $title";
    }
}

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

$itemId = $data['id'];

if (empty($fileId)) {
    ReturnJsonError('Не указан идентификатор элемента', 'null_id');
}

/*
$item = $record->items()->getById($itemId);

if (!$item) {
    $record->items()->createItem();
}

{$updates}

$item->save();
*/

ReturnJson(['data' => /*$this->execute('encodeData.php', $item)*/ $data]);

PHP;

$data = strtr($data, [
    '{$recordKey}'   => $recordKey,
    '{$billetClass}' => $billetClass,
    '{$widgetName}'  => $widgetName,
    '{$updates}'     => join("\n", $updates),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

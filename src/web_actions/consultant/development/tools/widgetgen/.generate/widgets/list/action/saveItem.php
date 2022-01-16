<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$updates = [];

foreach ($this->param('fields') as ['prop' => $prop, 'title' => $title, 'setter' => $setter, 'edit' => $edit]) {
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

$itemId = $data['id'] ?? '';

/*
$item = $record->items()->getById($itemId);

if (!$item) {
    $record->items()->createItem();
}

{$updates}

$item->save();
*/

ReturnJson(['data' => /*$this->execute('encodeData.php', $item)*/ $data + ['id' => time()]]);

PHP;

$data = strtr($data, [
    '{$billetClass}' => $this->param('part.billet'),
    '{$recordKey}'   => $this->param('part.key'),
    '{$widgetName}'  => $this->param('widget.name'),
    '{$updates}'     => join("\n", $updates),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

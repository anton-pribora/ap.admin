<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$billetClass = $this->param('part.billet');
$repositoryClass = $this->param('part.repository');
$recordKey = $this->param('part.key');

$widgetName = $this->param('widget.name');
$widgetStore = $this->param('widget.store');

$fields = $this->param('fields');

$updates = [];

foreach ($fields as ['prop' => $prop, 'title' => $title, 'setter' => $setter, 'edit' => $edit]) {
    if ($edit) {
        $updates[] = "\$record->{$setter}(\$data['{$prop}'] ?? '');  // $title";
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
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

{$updates}

$record->save();

$this->include('data.php');

PHP;

$data = strtr($data, [
    '{$recordKey}' => $recordKey,
    '{$billetClass}' => $billetClass,
    '{$widgetName}' => $widgetName,
    '{$widgetStore}' => $widgetStore,
    '{$updates}' => join("\n", $updates),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$fields = $this->param('fields');

$updates = [];

foreach ($fields as ['prop' => $prop, 'title' => $title, 'getter' => $getter, 'setter' => $setter, 'edit' => $edit]) {
    if ($edit) {
        $updates[] = "\$props[] = ['{$title}', \$data['{$prop}'] ?? '', [\$record, '{$getter}'], [\$record, '{$setter}'], \$defaultFormat];";
    }
}

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

$record = $this->argument();

$data       = $this->param('widget_data', [])['data'] ?? [];
$enableEdit = $this->param('{$recordKey}.edit') || $this->param('{$recordKey}.{$widgetName}.edit');

if (!$enableEdit) {
    ReturnJsonError('У вас нет прав на редактирование этих данных', 'forbidden');
}

$defaultFormat = static fn($v) => $v;

// Изменяемые свойства
$props = [];

{$updates}

$changes = [];

foreach ($props as [$prop, $new, $getter, $setter, $format]) {
    $old = $getter();

    if (is_array($old) || is_array($new)) {
        $diff = \Data\ArrayUtils::calcChanges((array) $old, (array) $new);

        if ($diff) {
            $setter($new);
            $changes[] = 'Изменено поле «<b>' . $prop . '</b>»: <ul><li>' . join('</li><li>', \Data\ArrayUtils::changesToTextArray($diff)) . '</li></ul>';
        }
    } elseif ($old != $new) {
        $setter($new);
        $changes[] = sprintf('Изменено поле «<b>%s</b>»: «%s» => «%s»', $prop, $format($old), $format($new));
    }
}

if ($changes) {
    $record->save();
    $record->addHistory('В запись <b>' . $record->name() . '</b> внесены изменения: <ul><li>' . join('</li><li>', $changes) . '</li></ul>');
}

$this->include('data.php');

PHP;

$data = strtr($data, [
    '{$billetClass}' => $this->param('part.billet'),
    '{$recordKey}'   => $this->param('part.key'),
    '{$widgetName}'  => $this->param('widget.name'),
    '{$widgetStore}' => $this->param('widget.store'),
    '{$updates}'     => join("\n", $updates),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

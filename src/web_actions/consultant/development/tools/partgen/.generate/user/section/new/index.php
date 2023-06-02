<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$fields = $this->param('fields');

$setters = [];
$changes = [];

foreach ($fields as ['edit' => $edit, 'title' => $title, 'getter' => $getter, 'setter' => $setter, 'prop' => $prop]) {
    if ($edit) {
        $setters[] = "\$record->{$setter}(Request()->get('$prop'));";
        $changes[] = "\$changes[] = \"«<b>{$title}</b>»: «\" . Html(\$record->{$getter}()) . \"»\";";
    }
}

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {billet} */

if (!Identity()->getPermit('{$recordKey}.add')) {
    Alert('У вас нет прав, чтобы добавлять новые записи', 'warning');
    return;
}

$data = Request()->getPostVariables();

if (Request()->isPost()) {
    $record = new {billet};
    {setters}

    $errors = [];

    // Обработка ошибок

    if (empty($errors)) {
        $record->save();

        $changes = [];
        {changes}

        $message = "Создана запись: <ul><li>" . join('</li><li>', $changes) . "</li></ul>";
        $record->addHistory($message);

        Redirect($record->urlAsset('url.view'));
    } else {
        set_request_extra_info(['errors' => $errors]);

        foreach ($errors as $error) {
            Alert($error, 'danger');
        }
    }
}

$params = [];

$menu = [];

//Template()->render('@extra/nav-tabs.php', Meta(__DIR__)->get('nav', []));
//Template()->render('@extra/list-inline.php', $menu);
Template()->render(__dir('.views/new_record_form.php'), $data, $params);

PHP;

$data = strtr($data, [
    '{billet}'     => $this->param('part.billet'),
    '{$recordKey}' => $this->param('part.key'),
    '{setters}'    => join("\n    ", $setters),
    '{changes}'    => join("\n        ", $changes),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

if (!Identity()->getPermit('profile.add')) {
    Alert('У вас нет прав, чтобы добавлять новые записи', 'warning');
    return;
}

$data = Request()->getPostVariables();

if (Request()->isPost()) {
    $record = new Project\Profile;
    $record->setType(Request()->get('type'));
    $record->setName(Request()->get('name'));

    $errors = [];

    // Обработка ошибок

    if (empty($errors)) {
        $record->save();

        $changes = [];
        $changes[] = "«<b>Тип профиля</b>»: «" . Html($record->type()) . "»";
        $changes[] = "«<b>name</b>»: «" . Html($record->name()) . "»";

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

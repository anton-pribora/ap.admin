<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

if (!Identity()->getPermit('profile.add')) {
    Alert('У вас нет прав, чтобы добавлять новые записи', 'warning');
    return;
}

$data = Request()->get('data', []);

if (Request()->isPost()) {
    $record = new Project\Profile;
    $record->setType('consultant');
    $record->setFirstName($data['name']['first'] ?? '');
    $record->setMiddleName($data['name']['middle'] ?? '');
    $record->setLastName($data['name']['last'] ?? '');
    $record->setPost($data['post'] ?? '');
    $record->setComment($data['comment']);
    $record->addRole('consultant');

    $errors = [];

    // Обработка ошибок

    if (empty($errors)) {
        $record->save();

        $changes = [];
        $changes[] = "«<b>Имя</b>»: «" . Html($record->fullName()) . "»";
        $changes[] = "«<b>Должность</b>»: «" . Html($record->post()) . "»";
        $changes[] = "«<b>Заметки</b>»: «" . Html($record->comment()) . "»";

        $message = "Создана запись #{$record->id()}: <ul><li>" . join('</li><li>', $changes) . "</li></ul>";
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

<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Role */

if (!Identity()->getPermit('role.add')) {
    Alert('У вас нет прав, чтобы добавлять новые записи', 'warning');
    return;
}

$data = Request()->getPostVariables();

if (Request()->isPost()) {
    $record = new Project\Role;
    $record->setTag(trim(Request()->get('tag'), ''));
    $record->setName(Request()->get('name'));
    $record->setComment(Request()->get('comment'));

    $errors = [];

    // Обработка ошибок

    if (empty($record->tag())) {
        $errors[] = 'Необходимо задать короткую метку';
    } elseif (\Project\RoleRepository::findOne(['tag' => $record->tag()])) {
        $errors[] = 'Короткая метка '  . json_encode_array($record->tag()) . ' уже используется, придумайте новую';
    }

    if (empty($errors)) {
        $record->save();

        $changes = [];
        $changes[] = "«<b>Коротая метка</b>»: «" . Html($record->tag()) . "»";
        $changes[] = "«<b>Название</b>»: «" . Html($record->name()) . "»";
        $changes[] = "«<b>Описание</b>»: «" . Html($record->comment()) . "»";

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

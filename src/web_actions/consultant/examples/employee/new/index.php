<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

if (!Identity()->getPermit('examples.employee.add')) {
    Alert('У вас нет прав, чтобы добавлять новые записи', 'warning');
    return;
}

$data = Request()->getPostVariables();

if (Request()->isPost()) {
    $record = new Project\Examples\Employee;
    $record->setName(Request()->get('name'));
    $record->setPost(Request()->get('post'));
    $record->setResponsibilities(Request()->get('responsibilities'));
    $record->save();

    Redirect($record->urlAsset('url.view'));
}

$params = [];

$menu = [];

//Template()->render('@extra/nav-tabs.php', Meta(__DIR__)->get('nav', []));
//Template()->render('@extra/list-inline.php', $menu);
Template()->render(__dir('.views/new_record_form.php'), $data, $params);

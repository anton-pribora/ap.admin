<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Elephant */

$data = Request()->getPostVariables();

if (Request()->isPost()) {
    $record = new Project\Elephant;
    $record->setName(Request()->get('name'));
    $record->setDescription(Request()->get('description'));
    $record->save();

    Redirect($record->urlAsset('url.view'));
}

$params = [];

$menu = [];

//Template()->render('@extra/nav-tabs.php', Meta(__DIR__)->get('nav', []));
//Template()->render('@extra/list-inline.php', $menu);
Template()->render(__dir('.views/new_record_form.php'), $data, $params);

<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Elephant */

$record = $this->param('record');

$params = [
    'elephant.edit' => Identity()->hasPermit('elephant.edit', $record),
];

Module('widgets')->execute('handle.php', $record, $params);

$menu = [];

//Template()->render('@extra/nav-tabs.php', Meta(__DIR__)->get('nav', []));
//Template()->render('@extra/list-inline.php', $menu);
Template()->render(__dir('.views/view.php'), $record, $params);

<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->param('record');

$params = [
    'profile.edit' => Identity()->getPermit('profile.edit', $record),
];

Module('widgets')->execute('handle.php', $record, $params);

$menu = [
    Module('project')->execute('history/button.php', ['section' => $record->historySection(), 'recordId' => $record->id(), 'viewAll' => true]),
];

//Template()->render('@extra/nav-tabs.php', Meta(__DIR__)->get('nav', []));
Template()->render('@extra/list-inline.php', $menu);
Template()->render(__dir('.views/view.php'), $record, $params);

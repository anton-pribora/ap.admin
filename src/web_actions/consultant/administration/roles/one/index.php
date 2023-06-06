<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Role */

$record = $this->param('record');

$params = [
    'role.edit'   => Identity()->getPermit('role.edit', $record),
    'role.remove' => Identity()->getPermit('role.remove', $record),
];

Module('widgets')->execute('handle.php', $record, $params);

$menu = [
    Module('project')->execute('history/button.php', ['section' => $record->historySection(), 'recordId' => $record->id(), 'viewAll' => true]),
];

//Template()->render('@extra/nav-tabs.php', Meta(__DIR__)->get('nav', []));
Template()->render('@extra/list-inline.php', $menu);
Template()->render(__dir('.views/view.php'), $record, $params);

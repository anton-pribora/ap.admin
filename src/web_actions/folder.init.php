<?php

use ApCode\Html\Element\A;

PathAlias()->set('@template', 'public-bs5');
PathAlias()->set('~/', '@views/');

Url()->setAlias(__DIR__ . '/', '@root/');

Layout()->prepend('head.title', Config()->get('project.name'));

foreach (Meta(__DIR__)->get('menu', []) as $row) {
    $link = new A($row['text'], $row['url']);

    if ($row['position'] ?? null == 'left') {
        Layout()->append('topLeftMenu', $link, $row['active']);
    } else {
        Layout()->append('topMenu', $link, $row['active']);
    }
}

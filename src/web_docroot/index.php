<?php

ini_set('display_errors', Config()->get('APPLICATION_ENV') !== 'production');

include '../bootstrap.php';

Layout()->startGrab('body.content');

Module('http')->execute(Request()->action());

if (Halt()->render()) {
    return true;
}

Layout()->endGrab();

// Инициализация шаблона
glob_include(ExpandPath('@template/init/*.php'));

Layout()->setLayoutFolder(ExpandPath('@layout/'));
Layout()->display();

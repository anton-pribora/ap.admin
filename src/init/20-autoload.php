<?php
// Компоненты проекта вне композера
glob_include(ROOT_DIR . '/components/*/bootstrap.php');

// Компоненты композера
glob_include(ROOT_DIR . '/vendor/autoload.php');

// Классы проекта
spl_autoload_register(function ($class) {
    $file = ROOT_DIR . '/classes/' . strtr($class, '\\', '/') . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

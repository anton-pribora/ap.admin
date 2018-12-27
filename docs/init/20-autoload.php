<?php

glob_include(ROOT_DIR .'/vendor/*/bootstrap.php');

spl_autoload_register(function ($class) {
    $file = ROOT_DIR .'/classes/'. strtr($class, '\\', '/') .'.php';
    
    if (file_exists($file)) {
        require $file;
    }
});
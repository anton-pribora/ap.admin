<?php

define('ROOT_DIR', __DIR__);
define('IS_CONSOLE', defined('STDIN'));

glob_include(__dir('init/*.php'));

if (IS_CONSOLE) {
    glob_include(__dir('init/console/*.php'));
} else {
    glob_include(__dir('init/web/*.php'));
}

function glob_include($pattern, $flags = 0) {
    foreach (glob($pattern, $flags) as $file) {
        include $file;
    }
}

function __dir($path = '') {
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
    $folder = dirname($backtrace[0]['file']);

    return "$folder/" . ltrim($path, '/');
}

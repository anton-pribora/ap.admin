<?php

if (empty(ini_get('error_log'))) {
    ini_set('error_log', __DIR__ . '/../../logs/php-errors.log');
}

if (ini_get('error_reporting') === '') {
    ini_set('error_reporting', E_ALL);
    ini_set('log_errors', true);
}

setlocale(LC_ALL, 'ru_RU.UTF-8', 'utf-8');

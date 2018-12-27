<?php

if (empty(ini_get('error_log'))) {
    ini_set('error_log', __DIR__ .'/../../logs/php-errors.log');
}

setlocale(LC_ALL, 'ru_RU.UTF-8', 'utf-8');

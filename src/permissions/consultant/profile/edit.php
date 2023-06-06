<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Project\Profile */
/* @var $record Project\Profile */

$consultant = $this->argument(0);
$record = $this->argument(1);

$result = null;

// Даём администраторам полный доступ на редактирование
if (is_null($result) && $consultant->isAdmin()) {
    $result = 'full';
}

// Для обычных пользователей разрешаем менять данные, но частично
if (is_null($result) && $consultant->id() && $consultant->id() == $record->id()) {
    $result = 'partial';
}

if (is_null($result)) {
    $result = false;
}

return $result;

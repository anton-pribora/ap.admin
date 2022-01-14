<?php

use ApCode\Html\Element\A;
use ApCode\Html\Element\UnescapedText;

$searchParams = [
    'name' => Request()->get('name'),
    'post' => Request()->get('post'),
];

$pagination = Pagination();

try {
    $items = Project\Examples\EmployeeRepository::findMany($searchParams, $pagination);
} catch (Exception $exception) {
    Alert('Ошибка: ' . $exception->getMessage(), 'danger');
    Alert('Скорее всего отсутствуют настройки для базы данных или не применены миграции', 'info');
    return;
}

$params = [];

$menu = [
    new A(new UnescapedText(Icons()->get('add') . 'Добавить запись'), ShortUrl(__dir('new/'))),
];

Template()->render('@extra/list-inline.php', $menu);
Template()->render(__dir('.views/search_form.php'), $searchParams);
Template()->render('@totalFound', $pagination, $params);
Template()->render('@pagination', $pagination);
Template()->render(__dir('.views/list.php') , $items, $pagination->startFrom() + 1);
Template()->render('@pagination', $pagination);

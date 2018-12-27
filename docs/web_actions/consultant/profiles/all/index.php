<?php 

Module('widgets')->execute('handle.php');

$searchParams = [
    'name' => Request()->get('name'),
];

$pagination = Pagination();

$items = Site\ConsultantRepository::findMany($searchParams, $pagination);

$params = [];

Template()->render('~/search-form.php', $searchParams);

Template()->render('@totalFound', $pagination, $params);
Template()->render('@pagination', $pagination);
Template()->render('~/list.php' , $items, $pagination->startFrom() + 1);
Template()->render('@pagination', $pagination);

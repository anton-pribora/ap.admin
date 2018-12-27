<?php

/* @var $this ApCode\Executor\RuntimeInterface */

$widgetData = $this->param('widget_data');

$entity = $widgetData['entity'] ?? null;
$params = $widgetData['params'] ?? [];

if (empty($entity)) {
    ReturnJsonError('Widget info::display(): Вы должны указать объект, который хотите показать');
}

$file = "../display/$entity.php";

if ($this->canExecute($file)) {
    return $this->execute($file, $entity, $params);
}

ReturnJsonError('Widget info::display(): Нет вида для '. $entity);
<?php

$categories = [
    ['id' => 1, 'title' => 'Панель управления', 'class' => 'title-purple'],
    ['id' => 2, 'title' => 'Глобальные планы' , 'class' => 'title-success'],
    ['id' => 3, 'title' => 'Интеграция' , 'class' => 'title-danger'],
];

$urgent = ' (<span title="as soon as possible">ASAP <i class="fa fa-bolt text-danger"></i></span>)';

$tasks = [
    ['category' => 1, 'title' => 'Бэкапы', 'class' => 'default', 'works' => [
        ['title' => 'Бэкапы систем', 'done' => false],
        ['title' => 'Загрузка бэкапов', 'done' => false],
        ['title' => 'Восстановление из бэкапа', 'done' => false],
        ['title' => 'Удаление бэкапов', 'done' => false],
    ],],
    ['category' => 1, 'title' => 'Управление системой', 'class' => 'success', 'works' => [
        ['title' => 'Настройка пользователей', 'done' => true],
        ['title' => 'Просмотр настроек', 'done' => true],
    ],],
    ['category' => 1, 'title' => 'Работа с git', 'class' => 'success', 'works' => [
        ['title' => 'Просмотр веток', 'done' => true],
        ['title' => 'Переключение веток', 'done' => true],
        ['title' => 'Применение миграций', 'done' => true],
    ],],
    ['category' => 1, 'title' => 'Панель администратора', 'class' => 'default', 'works' => [
        ['title' => 'Настройки', 'done' => false],
        ['title' => 'Отправка почты', 'done' => true],
    ],],
    ['category' => 2, 'title' => 'Тарифы', 'class' => 'default', 'works' => [
        ['title' => 'Баланс', 'done' => true],
        ['title' => 'Платежи', 'done' => true],
        ['title' => 'Счета', 'done' => false],
        ['title' => 'Отчёты', 'done' => false],
        ['title' => 'Блокировка', 'done' => false],
    ],],
    ['category' => 2, 'title' => 'Сервер', 'class' => 'default', 'works' => [
        ['title' => 'Убрать wordpress' . $urgent, 'done' => false],
        ['title' => 'Заменить MySQL на MariaDB' . $urgent, 'done' => false],
        ['title' => 'Удалить ненужные данные' . $urgent, 'done' => false],
        ['title' => 'Удалить GNOME' . $urgent, 'done' => false],      
    ],],
    ['category' => 3, 'title' => 'Основной сайт', 'class' => 'success', 'works' => [
        ['title' => 'Форма регистрации', 'done' => true],
        ['title' => 'Отправка уедомлений о новой регистрации', 'done' => true],
    ],],
];

$getCategoryTasks = function ($categoryId) use ($tasks) {
    $result = [];
    
    foreach ($tasks as $task) {
        if ($task['category'] == $categoryId) {
            $result[] = $task;
        }
    }
    
    return $result;
};

?>
<style>
<!--
.plan-title { margin: 0px; }

.title-purple  { border-color: #694D9F;background: #694D9F;color: #fff; }
.title-info    { border-color: #B4E1E4;background: #81c7e1;color: #fff; }
.title-danger  { border-color: #B63E5A;background: #E26868;color: #fff; }
.title-warning { border-color: #F3F3EB;background: #E9CEAC;color: #fff; }
.title-success { border-color: #19B99A;background: #20A286;color: #fff; }

.checked-list-box .fa-square-o, .checked-list-box .fa-check-square-o { position: relative; left: -1.6em; margin-right: -1.6em; }
.checked-list-box .content { padding-left: 1.6em; }
.checked-list-box {margin: 5px 10px;}
.checked-list-box li {margin: 0px 0px 5px 0px;}
-->
</style>
<div class="row">
<?php foreach ($categories as $category) {?>
  <div class="col-lg-4">
    <div class="well well-sm <?php echo $category['class']?>">
      <h3 class="plan-title"><?php echo $category['title']?></h3>
    </div>
<?php foreach ($getCategoryTasks($category['id']) as $task) {?>
    <div class="panel panel-<?php echo $task['class'] ?? 'default'?>">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo $task['title']?></h3>
      </div>
      <ul class="checked-list-box list-unstyled">
<?php foreach ($task['works'] as $work) {?>
        <li>
          <div class="content">
            <i class="<?php echo empty($work['done']) ? 'fa fa-fw fa-square-o' : 'fa fa-fw fa-check-square-o';?>"></i>
            <?php echo $work['title']?>
          </div>
        </li>
<?php }?>
      </ul>
    </div>
<?php }?>
  </div>
<?php }?>
</div>
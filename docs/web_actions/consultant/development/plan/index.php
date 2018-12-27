<?php

$categories = [
    ['id' => 1, 'title' => 'Control panel', 'class' => 'title-purple'],
    ['id' => 2, 'title' => 'Global goals' , 'class' => 'title-success'],
    ['id' => 3, 'title' => 'Integration' , 'class' => 'title-danger'],
];

$urgent = ' (<span title="as soon as possible">ASAP <i class="fa fa-bolt text-danger"></i></span>)';

$tasks = [
    ['category' => 1, 'title' => 'Backups', 'class' => 'default', 'works' => [
        ['title' => 'Make system backups', 'done' => false],
        ['title' => 'Download backups', 'done' => false],
        ['title' => 'Restore backups', 'done' => false],
        ['title' => 'Remove backups', 'done' => false],
    ],],
    ['category' => 1, 'title' => 'System control', 'class' => 'success', 'works' => [
        ['title' => 'Edit system users', 'done' => true],
        ['title' => 'View system settings', 'done' => true],
    ],],
    ['category' => 1, 'title' => 'System git', 'class' => 'success', 'works' => [
        ['title' => 'View branches', 'done' => true],
        ['title' => 'Chechout branch', 'done' => true],
        ['title' => 'Apply migrations', 'done' => true],
    ],],
    ['category' => 1, 'title' => 'Panel', 'class' => 'default', 'works' => [
        ['title' => 'Settings', 'done' => false],
        ['title' => 'Emailing', 'done' => true],
    ],],
    ['category' => 2, 'title' => 'Tariffs', 'class' => 'default', 'works' => [
        ['title' => 'System balance', 'done' => true],
        ['title' => 'Payments', 'done' => true],
        ['title' => 'Invoices', 'done' => false],
        ['title' => 'Reports', 'done' => false],
        ['title' => 'Blocking systems', 'done' => false],
    ],],
    ['category' => 2, 'title' => 'Server', 'class' => 'default', 'works' => [
        ['title' => 'Move wordpress out of here' . $urgent, 'done' => false],
        ['title' => 'Replace MySQL with MariaDB' . $urgent, 'done' => false],
        ['title' => 'Remove useless systems and backups' . $urgent, 'done' => false],
        ['title' => 'Remove GNOME' . $urgent, 'done' => false],      
    ],],
    ['category' => 3, 'title' => 'kryptos24.pl', 'class' => 'success', 'works' => [
        ['title' => 'Register new system', 'done' => true],
        ['title' => 'Send notify to admin after registration', 'done' => true],
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
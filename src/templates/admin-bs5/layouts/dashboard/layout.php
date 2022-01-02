<?php

Layout()->appendOnce('head.css.code', file_get_contents(__dir('style.css')));

/* @var $menu Data\Layout\Menu */

?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <?php echo Layout()->renderIfNotEmpty('head.title') ?>
  <?php echo Layout()->renderIfNotEmpty('head.metas') ?>
  <?php echo Layout()->renderIfNotEmpty('head.html') ?>
  <?php echo Layout()->renderIfNotEmpty('head.css.links') ?>
  <?php echo Layout()->renderIfNotEmpty('head.js.links') ?>
  <?php echo Layout()->renderIfNotEmpty('head.css.code') ?>
  <?php echo Layout()->renderIfNotEmpty('head.js.code') ?>
</head>

<body class="d-flex vh-100">
<?php echo Layout()->renderIfNotEmpty('body.css.code') ?>
<?php echo Layout()->renderIfNotEmpty('body.js.begin') ?>
<div class="flex-column scrollarea" style="min-width: 220px">
  <a href="/" class="d-flex align-items-center px-4 pt-3 pb-2 mb-3 link-dark text-decoration-none border-bottom">
  <span class="fs-5 fw-semibold">
    <i class="bi bi-tools" style="font-size: 1.2rem"></i>
    Ap.admin
  </span>
  </a>

  <ul class="list-unstyled ps-0">
<?php $menu = Layout()->getVar('menu'); ?>
<?php foreach ($menu->items() as $i => $item) { ?>
  <?php if ($item->isSeparator) { ?>
    <li class="border-top my-3"></li>
  <?php continue; } ?>

  <?php if ($item->hasSubMenu()) { ?>
    <li class="mb-1">
      <button class="btn btn-toggle align-items-center rounded <?=$item->hasActiveItems() ? '' : 'collapsed'?>"
              data-bs-toggle="collapse"
              data-bs-target="#menu-<?=$i?>"
              aria-expanded="<?=$item->hasActiveItems() ? 'true' : 'false'?>"
      >
        <?=$item->text?>
      </button>
      <div class="<?=$item->hasActiveItems() ? 'collapse show' : 'collapse'?>" id="menu-<?=$i?>">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
    <?php foreach ($item->subMenu()->items() as $subMenuItem) { ?>
          <li><a class="link-dark <?=$subMenuItem->active ? 'fw-bold' : ''?>" href="<?=$subMenuItem->href?>"><?=$subMenuItem->text?></a></li>
    <?php } ?>
        </ul>
      </div>
    </li>
  <?php continue; } ?>
<?php } ?>
  </ul>

</div>
<div class="b-example-divider"></div>
<div class="d-flex flex-column align-content-stretch flex-grow-1">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
              aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
<?php
if (Layout()->hasVar('additionalmenu')) {
     $menu = Layout()->getVar('additionalmenu');
?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              Дополнительное меню
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <?php foreach ($menu->items() as $item) { ?>
              <?php if ($item->isSeparator) { ?>
              <li><hr class="dropdown-divider"></li>
              <?php } else { ?>
              <li><a class="dropdown-item" href="<?=$item->href?>"><?=$item->text?></a></li>
              <?php } ?>
            <?php } ?>
            </ul>
          </li>
<?php } ?>
        </ul>

        <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
<?php
if (Layout()->hasVar('usermenu')) {
     $menu = Layout()->getVar('usermenu');
?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarUserMenu" role="button" data-bs-toggle="dropdown"
               aria-expanded="false">
              <i class="bi bi-person bi-fix" style="font-size: 1.2rem"></i>
              <?=Identity()->getName();?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserMenu">
            <?php foreach ($menu->items() as $item) { ?>
              <?php if ($item->isSeparator) { ?>
              <li><hr class="dropdown-divider"></li>
              <?php } else { ?>
              <li><a class="dropdown-item" href="<?=$item->href?>"><?=$item->text?></a></li>
              <?php } ?>
            <?php } ?>
            </ul>
          </li>
<?php } ?>
        </ul>

      </div>
    </div>
  </nav>
  <div class="overflow-auto flex-grow-1 d-flex flex-column">
    <div class="container p-4 me-auto ms-0" id="content">
      <?php if (Layout()->exists('breadcrumbs')) {?>
        <nav
          style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
          aria-label="breadcrumb"
        >
          <ol class="breadcrumb">
            <?php foreach (Layout()->retrieve('breadcrumbs') as [$item, $data]) { ?>
            <li class="breadcrumb-item"><?=$item?></li>
            <?php } ?>
          </ol>
        </nav>
      <?php } ?>

      <?php if (Layout()->hasVar('title')) {?>
        <h2 class="border-bottom pb-2 mb-4"><?php echo Layout()->getVar('title')?></h2>
      <?php }?>

      <?php echo Layout()->renderIfNotEmpty('body.alerts')?>
      <?php echo Layout()->render('body.content')?>
    </div>
    <footer class="mt-auto py-3 me-auto ms-0 container text-center text-secondary">
        <hr class="w-75 mx-auto" />
        <?php echo Layout()->render('stats')?>
    </footer>
  </div>
</div>

<?php echo Layout()->renderIfNotEmpty('content.end.html') ?>
<?php echo Layout()->renderIfNotEmpty('body.js.links') ?>
<?php echo Layout()->renderIfNotEmpty('body.js.code') ?>

</body>
</html>

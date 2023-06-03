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

<body>
<?php echo Layout()->renderIfNotEmpty('body.css.code') ?>
<?php echo Layout()->renderIfNotEmpty('body.js.begin') ?>

<div id="brandLink" class="d-none d-md-block border-bottom">
  <a href="<?=ExternalUrl('@consultant/')?>" class="d-flex align-items-center px-4 pt-3 pb-2 mb-3 link-dark text-decoration-none">
    <span class="fs-5 fw-semibold">
      <?=Config()->get('project.logo')?>
      <?=Config()->get('project.name')?>
    </span>
  </a>
</div>

<div id="topMenuBlock">
  <nav class="navbar navbar-expand-lg navbar-light bg-light d-print-none">
    <div class="container-fluid">
      <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="offcanvas"
              data-bs-target="#leftMenu" aria-controls="leftMenu" aria-expanded="false"
              aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <a href="/" class="d-md-none d-flex align-items-center mx-auto link-dark text-body-secondary text-decoration-none">
        <span class="fs-5 fw-semibold">
          <?=Config()->get('project.logo')?>
          <?=Config()->get('project.name')?>
        </span>
      </a>

      <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="offcanvas"
              data-bs-target="#userMenu" aria-controls="userMenu" aria-expanded="false"
              aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="offcanvas offcanvas-end" tabindex="-1" id="userMenu">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Меню пользователя</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav mb-2 mb-lg-0">
<?php
if (Layout()->hasVar('additionalmenu') && Layout()->getVar('additionalmenu')->items()) {
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

          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav">
              <a href="mailto:<?=Html(Config()->get('project.help'))?>?<?=strtr(http_build_query(['subject' => '[' . Config()->get('project.name') . '] Проблема', 'body' => "Привет,\nУ меня возникли проблемы с [описание проблемы]"]), ['+' => '%20'])?>" class="nav-link"><i class="bi bi-bug me-1"></i>Сообщить о проблеме</a>
            </li>
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
    </div>
  </nav>
</div>

<div id="leftMenuBlock" class="d-none d-md-block pt-3">
<?php ob_start(); ?>
  <ul class="list-unstyled ps-0">
<?php $menu = Layout()->getVar('menu'); ?>
<?php foreach ($menu->items() as $i => $item) { ?>
  <?php if (!$item->visible) continue; ?>
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
      <?php if (!$subMenuItem->visible) continue; ?>
          <li><a class="link-dark <?=$subMenuItem->active ? 'fw-bold' : ''?>" href="<?=$subMenuItem->href?>"><?=$subMenuItem->text?></a></li>
    <?php } ?>
        </ul>
      </div>
    </li>
  <?php continue; } ?>
<?php } ?>
  </ul>
<?php echo $leftMenu = ob_get_clean(); ?>
</div>

<div id="leftMenu" class="offcanvas offcanvas-start">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Разделы</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
<?php echo $leftMenu; ?>
  </div>
</div>

<div id="dividerBar" class="d-none d-md-block"></div>

<div id="centralBlock" class="d-flex align-content-between flex-wrap">
  <div class="<?=Layout()->getVar('fluid') ? 'container-fluid' : 'container'?> p-4 me-auto ms-0" id="content">
    <?php if (Layout()->exists('breadcrumbs')) {?>
      <nav
        style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb"
        class="d-print-none"
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
  <div id="footerBlock" class="container m-0">
    <footer class="py-3 text-center text-secondary d-print-none">
      <hr class="w-75 mx-auto" />
      <?php echo Layout()->render('stats')?>
    </footer>
  </div>
</div>
<?php echo Layout()->renderIfNotEmpty('body.content.end') ?>
<?php echo Layout()->renderIfNotEmpty('body.js.links') ?>
<?php echo Layout()->renderIfNotEmpty('body.js.code') ?>
<script>
  if (typeof(app) !== 'undefined' && app.mount) {
    app.mount('#content');
  }
</script>
<?php echo Layout()->renderIfNotEmpty('body.scripts') ?>
</body>
</html>

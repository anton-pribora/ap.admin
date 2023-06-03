<?php

foreach (glob(__dir('assets/*.css')) as $css) {
    Layout()->append('head.css.code', file_get_contents($css));
}

?>
<!DOCTYPE html>
<html lang="ru" class="h-100">
  <head>
    <?php echo Layout()->renderIfNotEmpty('head.title')?>
    <?php echo Layout()->renderIfNotEmpty('head.metas')?>
    <?php echo Layout()->renderIfNotEmpty('head.html')?>
    <?php echo Layout()->renderIfNotEmpty('head.css.links')?>
    <?php echo Layout()->renderIfNotEmpty('head.js.links')?>
    <?php echo Layout()->renderIfNotEmpty('head.css.code')?>
    <?php echo Layout()->renderIfNotEmpty('head.js.code')?>
  </head>

  <body class="d-flex flex-column h-100">
    <?php echo Layout()->renderIfNotEmpty('body.css.code')?>
    <?php echo Layout()->renderIfNotEmpty('body.js.begin')?>

    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-bottom-dark" data-bs-theme="dark">
      <div class="container-md">
        <a class="navbar-brand" href="/"><?=Config()->get('project.name')?></a>
          <ul class="navbar-nav  me-auto">
            <?php echo Layout()->renderIfNotEmpty('topMenu');?>
          </ul>
          <ul class="navbar-nav">
            <?php echo Layout()->renderIfNotEmpty('topLeftMenu');?>
          </ul>
      </div>
    </nav>

    <?php if (Layout()->exists('body.alerts')) { ?>
      <div class="container"><?php echo Layout()->renderIfNotEmpty('body.alerts')?></div>
    <?php } ?>

    <div>
      <?php echo Layout()->render('body.content')?>
    </div>

    <footer class="footer mt-auto py-3 bg-light">
      <div class="container">
        <span class="text-body-secondary small">&copy; <?=date('Y')?> Антон Прибора <a class="text-body-secondary" href="https://anton-pribora.ru">https://anton-pribora.ru</a> </span>
      </div>
    </footer>

<?php echo Layout()->renderIfNotEmpty('body.content.end')?>
<?php echo Layout()->renderIfNotEmpty('body.js.links')?>
<?php echo Layout()->renderIfNotEmpty('body.js.code')?>
  </body>
</html>

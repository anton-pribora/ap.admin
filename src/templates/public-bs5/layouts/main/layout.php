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

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-md">
        <a class="navbar-brand" href="/">Ap.admin</a>
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
        <span class="text-muted">&copy; 2022 Anton N Pribora</span>
      </div>
    </footer>

<?php echo Layout()->renderIfNotEmpty('body.content.end')?>
<?php echo Layout()->renderIfNotEmpty('body.js.links')?>
<?php echo Layout()->renderIfNotEmpty('body.js.code')?>
  </body>
</html>

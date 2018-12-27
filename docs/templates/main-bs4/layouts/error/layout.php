<?php 

foreach (glob(__dir('assets/*.css')) as $css) {
    Layout()->append('head.css.code', file_get_contents($css));
}

?>
<!DOCTYPE html>
<html <?php echo Layout()->hasVar('ng-app') ? 'ng-app="'. Layout()->getVar('ng-app') .'"' : '';?>>
  <head>
    <?php echo Layout()->renderIfNotEmpty('head.title')?>
    <?php echo Layout()->renderIfNotEmpty('head.metas')?>
    <?php echo Layout()->renderIfNotEmpty('head.html')?>
    <?php echo Layout()->renderIfNotEmpty('head.css.cdn')?>
    <?php echo Layout()->renderIfNotEmpty('head.css.links')?>
    <?php echo Layout()->renderIfNotEmpty('head.js.cdn')?>
    <?php echo Layout()->renderIfNotEmpty('head.js.links')?>
    <?php echo Layout()->renderIfNotEmpty('head.css.code')?>
    <?php echo Layout()->renderIfNotEmpty('head.js.code')?>
  </head>

  <body>
    <?php echo Layout()->renderIfNotEmpty('body.css.code')?>
    <?php echo Layout()->renderIfNotEmpty('body.js.begin')?>
    
    <div class="container">
        <nav class="navbar navbar-dark navbar-expand-md bg-dark">
            <div class="container-fluid"><a class="navbar-brand" href="/">Ap.admin</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse"
                    id="navcol-1">
                    <ul class="nav navbar-nav">
                        <li class="nav-item active" role="presentation"><a class="nav-link active" href="/">О продукте</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="/manual/">Документация</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="/download/">Скачать</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="/demo/">Демо</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container">
      <?php echo Layout()->renderIfNotEmpty('body.alerts')?>
      <?php echo Layout()->render('body.content')?>
    </div>
    
    <div class="footer-basic">
        <footer>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Home</a></li>
                <li class="list-inline-item"><a href="#">Services</a></li>
                <li class="list-inline-item"><a href="#">About</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
            </ul>
            <p class="copyright">Антон Прибора © 2018</p>
        </footer>
    </div>
          
<?php echo Layout()->renderIfNotEmpty('content.end.html')?>
<?php echo Layout()->renderIfNotEmpty('body.js.cdn')?>    
<?php echo Layout()->renderIfNotEmpty('body.js.links')?>
<?php echo Layout()->renderIfNotEmpty('body.js.code')?>
  </body>
</html>

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
<style type="text/css">
.navbar-brand {
  padding: 0px;
}
.navbar-brand>img {
  height: 100%;
  padding: 15px;
  width: auto;
}

.navbar-brand>img {
  padding: 13px 15px;
}
@media(min-width: 480px) {
    .navbar-header {min-width: 250px;}
}
.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>
</head>

<body>
<?php echo Layout()->renderIfNotEmpty('body.css.code')?>
<?php echo Layout()->renderIfNotEmpty('body.js.begin')?>
          
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top example3" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <a class="navbar-brand" href="/" style="color: #E9771C">
                  <img alt="Logo" src="<?php echo ExpandUrl('@root/img/logo.png')?>">
                </a>
            </div>
            <!-- /.navbar-header -->
            
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown" id="userMenu">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <?php echo Identity()->getName()?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
						<?php echo Layout()->renderIfNotEmpty('usermenu')?>  
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
<?php echo Layout()->render('menu')?>
<?php if (Layout()->hasVar('menu')) {?>
  <?php foreach (Layout()->getVar('menu')->items() as $firstLevelItem) { ?>
    <li <?php if ($firstLevelItem->active || $firstLevelItem->hasActiveItems()) { echo 'class="active"';}?>>
      <?php if ($firstLevelItem->hasSubMenu()) {?>
      <a href="#"><?php echo $firstLevelItem->text?><span class="fa arrow"></span></a>
      <ul class="nav nav-second-level <?php if ($firstLevelItem->hasActiveItems()) {echo 'in';}?>">
        <?php foreach ($firstLevelItem->subMenu()->items() as $secondLevelItem) {?>
          <li <?php if ($secondLevelItem->active || $secondLevelItem->hasActiveItems()) { echo 'class="active"';}?>>
            <?php if ($secondLevelItem->hasSubMenu()) {?>
            <a href="#"><?php echo $secondLevelItem->text;?><span class="fa arrow"></span></a>
            <ul class="nav nav-third-level <?php if ($secondLevelItem->hasActiveItems()) {echo 'in';}?>">
              <?php foreach ($secondLevelItem->subMenu()->items() as $thirdLevelItem) {?>
                <li <?php if ($thirdLevelItem->active || $thirdLevelItem->hasActiveItems()) { echo 'class="active"';}?>>
                  <a href="<?php echo $thirdLevelItem->href?>" <?php if ($thirdLevelItem->active) { echo 'class="active"';}?>><?php echo $thirdLevelItem->text;?></a>
                </li>
              <?php }?>
            </ul>
            <?php } else {?>
            <a href="<?php echo $secondLevelItem->href?>" <?php if ($secondLevelItem->active) { echo 'class="active"';}?>><?php echo $secondLevelItem->text;?></a>
            <?php }?>
          </li>
        <?php }?>
      </ul>
      <?php } else {?>
      <a <?php if ($firstLevelItem->active) { echo 'class="active"';}?> href="<?php echo $firstLevelItem->href?>"><?php echo $firstLevelItem->text?></a>
      <?php }?>
    </li>
  <?php }?>
<?php }?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                	<?php if (Layout()->hasVar('title')) {?>
                    	<h1 class="page-header"><?php echo Layout()->getVar('title')?></h1>
                    <?php }?>
                    <?php echo Layout()->renderIfNotEmpty('breadcrumbs')?>
                  <div style="max-width: 1140px">
                    <?php echo Layout()->renderIfNotEmpty('body.alerts')?>
                    <?php echo Layout()->render('body.content')?>
                  </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
        <div class="footer">
        	<?php echo Layout()->render('stats')?>
        </div>
<?php echo Layout()->renderIfNotEmpty('content.end.html')?>
    </div>

<?php echo Layout()->renderIfNotEmpty('body.js.cdn')?>    
<?php echo Layout()->renderIfNotEmpty('body.js.links')?>
<?php echo Layout()->renderIfNotEmpty('body.js.code')?>

</body>
</html>

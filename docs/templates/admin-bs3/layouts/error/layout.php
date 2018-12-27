<!DOCTYPE>
<html>
<head>
<?php echo Layout()->renderIfNotEmpty('head.title')?>
<?php echo Layout()->renderIfNotEmpty('head.metas')?>
<?php echo Layout()->renderIfNotEmpty('head.html')?>
<?php echo Layout()->renderIfNotEmpty('head.css.links')?>
<?php echo Layout()->renderIfNotEmpty('head.js.links')?>
<?php echo Layout()->renderIfNotEmpty('head.css.code')?>
<?php echo Layout()->renderIfNotEmpty('head.js.code')?>
</head>

<body>
<?php echo Layout()->renderIfNotEmpty('body.css.code')?>

<div class="container">
  <div class="row">
    <div class="span12">
      <div class="hero-unit center">
      	<?php echo Layout()->renderIfNotEmpty('body.content')?>
      </div>
    </div>
  </div>
</div>

<?php echo Layout()->renderIfNotEmpty('body.js.links')?>
<?php echo Layout()->renderIfNotEmpty('body.js.code')?>
</body>

</html>
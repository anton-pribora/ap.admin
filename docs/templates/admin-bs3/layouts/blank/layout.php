<!DOCTYPE html>
<html>
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

<?php echo Layout()->renderIfNotEmpty('body.content')?>

<?php echo Layout()->renderIfNotEmpty('body.js.cdn')?>    
<?php echo Layout()->renderIfNotEmpty('body.js.links')?>
<?php echo Layout()->renderIfNotEmpty('body.js.code')?>

  </body>
</html>

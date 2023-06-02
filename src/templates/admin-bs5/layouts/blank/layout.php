<!DOCTYPE html>
<html style="font-size: 14px;" lang="ru">
<head>
<?php echo Layout()->renderIfNotEmpty('head.title')?>
<?php echo Layout()->renderIfNotEmpty('head.metas')?>
<?php echo Layout()->renderIfNotEmpty('head.html')?>
<?php echo Layout()->renderIfNotEmpty('head.css.links')?>
<?php echo Layout()->renderIfNotEmpty('head.js.links')?>
<?php echo Layout()->renderIfNotEmpty('head.css.code')?>
<?php echo Layout()->renderIfNotEmpty('head.js.code')?>
  <style>
    .btn-default {
        color: #333;
        background-color: #fff;
        border-color: #ccc;
    }

    .btn-default:focus {
        color: #333;
        background-color: #e6e6e6;
        border-color: #8c8c8c;
    }

    .btn-default:hover {
        color: #333;
        background-color: #e6e6e6;
        border-color: #adadad;
    }

    .btn-default:active {
        color: #333;
        background-color: #e6e6e6;
        border-color: #adadad;
    }

    .btn-default.disabled, .btn-default:disabled {
        border-color: #ccc;
    }

    .btn-group-xs > .btn, .btn-xs {
        padding: .25rem .4rem;
        font-size: .875rem;
        line-height: .5;
        border-radius: .2rem;
    }
  </style>
</head>

<body>
<?php echo Layout()->renderIfNotEmpty('body.css.code')?>

<?php echo Layout()->renderIfNotEmpty('body.content')?>

<?php echo Layout()->renderIfNotEmpty('body.js.links')?>
<?php echo Layout()->renderIfNotEmpty('body.js.code')?>

</body>
</html>

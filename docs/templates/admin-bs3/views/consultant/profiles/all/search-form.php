<?php
use ApCode\Html\Element\Input;
?>
<form class="form-inline" method="get" action="">
<?php
foreach (Url()->getStaticParams() as $name => $value) {
    echo new Input($value, $name, 'hidden');
}
?>
  <div class="form-group">
    <input type="text" size="30" class="form-control" name="name" placeholder="Имя пользователя" value="<?php echo Html($this->param('name'))?>">
  </div>
  <input type="submit" class="btn btn-default" value="Найти">
</form>

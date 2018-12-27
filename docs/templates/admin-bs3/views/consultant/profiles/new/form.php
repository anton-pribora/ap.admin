<?php 

use Site\Consultant;

/* @var $this ApCode\Template\Template */

$data = $this->param('data', []);

$value = function ($name, $default = NULL) use ($data) {
    return isset($data[$name]) ? $data[$name] : $default;
};

if (!$this->param('canAddNewProfile')) {
    Layout()->append('body.js.code', '$("form").find("input, select, button").attr("disabled", true);');
}

$passwordTrick = empty($value('password'));

?>

<?php if (!$this->param('canAddNewProfile')) {?>
<div class="alert alert-warning">
  <p>У вас нет прав доступа для добавления нового пользователя.</p>
</div>
<?php }?>

<?php if ($this->param('errors')) {?>
<div class="alert alert-danger">
  <p>Ошибки:</p>
  <ul>
<?php foreach ($this->param('errors', []) as $error) {?>
    <li><?php echo $error?></li>
<?php }?>
  </ul>
</div>
<?php }?>

<form class="form-horizontal" method="post" ng-controller="newProfileController">
<fieldset>
<legend>
  Новый пользователь
</legend>

<div class="form-group">
  <label class="col-md-4 control-label">Имя</label>
  <div class="col-md-8"> 
    <input type="text" class="form-control" placeholder="" name="firstName" value="<?php echo Html($value('firstName'))?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Фамилия</label>
  <div class="col-md-8"> 
    <input type="text" class="form-control" placeholder="" name="lastName" value="<?php echo Html($value('lastName'))?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Должность</label>
  <div class="col-md-8"> 
    <input type="text" class="form-control" placeholder="" name="post" value="<?php echo Html($value('post'))?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Роль</label>
  <div class="col-md-8"> 
    <select class="form-control" name="roleId">
      <option value="">(выберите роль)</option>
<?php foreach (Consultant::roles() as $id => $name) {?>
      <option <?php if ($value('roleId') == $id) echo 'selected';?> value="<?php echo Html($id)?>"><?php echo Html($name)?></option>
<?php }?>
    </select>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Почта</label>
  <div class="col-md-8"> 
    <input type="text" class="form-control" placeholder="" name="email" value="<?php echo Html($value('email'))?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Телефон</label>
  <div class="col-md-8"> 
    <input type="text" class="form-control" placeholder="" name="phone" value="<?php echo Html($value('phone'))?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Skype</label>
  <div class="col-md-8"> 
    <input type="text" class="form-control" placeholder="" name="skype" value="<?php echo Html($value('skype'))?>">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Логин</label>
  <div class="col-md-8"> 
    <input type="text" class="form-control" placeholder="" name="login" value="<?php echo Html($value('login'))?>" autocomplete="off">
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Пароль</label>
  <div class="col-md-8">
<?php if ($passwordTrick) {?>
    <input type="text" class="form-control" placeholder="" name="password" value="<?php echo Html($value('password'))?>" autocomplete="off" onfocus="this.setAttribute('type', 'password')">
<?php } else {?>
    <input type="password" class="form-control" placeholder="" name="password" value="<?php echo Html($value('password'))?>" autocomplete="off">
<?php }?>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-8">
    <button name="createProfile" value="1" type="submit" class="btn btn-primary"><?php echo Icon('add')?> Добавить</button>
  </div>
</div>

</fieldset>
</form>
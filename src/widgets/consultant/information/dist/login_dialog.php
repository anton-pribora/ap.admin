<?php

use Site\Consultant;

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */

$consultant = $this->argument();

Layout()->append('body.js.code', file_get_contents(__dir('login_controller.js')));

Layout()->startGrab('body.content.end');
?>
<form name="form" ng-controller="consultantInformationLoginController">
<div class="modal fade" role="dialog" id="consultantInformationLoginDialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Изменить логин или пароль</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Логин (от 3 символов)</label>
          <input type="text" class="form-control" ng-model="consultant.login">
        </div>
        <div class="form-group">
          <label>Пароль (от 4 символов)</label>
          <input type="text" class="form-control" ng-model="consultant.password" placeholder="Оставьте пустым, если вы не хотите менять пароль" onfocus="this.setAttribute('type', 'password')">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary" ng-click="submit()">Сохранить</button>
      </div>
    </div>
  </div>
</div>
</form>
<?php 
Layout()->endGrab();

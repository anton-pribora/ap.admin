<?php

use Site\Consultant;

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */

$consultant = $this->argument();

Layout()->append('body.js.code', file_get_contents(__dir('edit_controller.js')));

Layout()->startGrab('content.end.html');
?>
<form name="form" ng-controller="consultantInformationEditController">
<div class="modal fade" role="dialog" id="consultantInformationEditDialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Изменить информацию</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Имя</label>
              <input type="text" class="form-control" ng-model="consultant.first_name">
            </div>
            <div class="form-group">
              <label>Фамилия</label>
              <input type="text" class="form-control" ng-model="consultant.last_name">
            </div>
            <div class="form-group">
              <label>Должность</label>
              <input type="text" class="form-control" ng-model="consultant.post">
            </div>
            <div class="form-group">
              <label>Роль</label>
              <select class="form-control" ng-model="consultant.role.id" ng-disabled="!consultant.role.editable">
                <option value="">(выберите роль)</option>
<?php foreach (Consultant::roles() as $id => $name) {?>
                <option value="<?php echo Html($id)?>"><?php echo Html($name)?></option>
<?php }?>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Email</label>
              <input type="text" class="form-control" ng-model="consultant.email">
            </div>
            <div class="form-group">
              <label>Телефон</label>
              <input type="text" class="form-control" ng-model="consultant.phone">
            </div>
            <div class="form-group">
              <label>Skype</label>
              <input type="text" class="form-control" ng-model="consultant.skype">
            </div>
          </div>
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

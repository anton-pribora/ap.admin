<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Role */

$record       = $this->argument();
$enableEdit   = $this->param('enableEdit');
$enableRemove = $this->param('enableRemove');

RequireLib('vue3');
RequireLib('toast');
RequireLib('confirm');

if ($enableEdit) {
    $this->include(__dir('edit_dialog.php'));
}

Layout()->append('body.js.code', file_get_contents(__dir('view_controller.js')));

Layout()->startGrab('body.content.end');

?>
<script type="text/html" id="roleInformationViewForm">
  <div class="card">
    <div class="card-header py-1 d-flex justify-content-between align-middle">
      <div><i class="bi bi-info-circle me-1"></i>Свойства</div>
<?php if ($enableEdit) { ?>
      <div v-if="!data.deleting" class="btn-group" role="group">
        <button class="btn btn-default btn-sm py-0" @click="edit(data)"><i class="bi bi-pencil me-1"></i>Изменить</button>
<?php if ($enableRemove) { ?>
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-default btn-sm py-0 px-1 text-body-secondary" data-bs-toggle="dropdown">
            <i class="bi bi-caret-down-fill small"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#" @click.prevent="remove(data)"><i class="bi bi-trash me-1"></i>Удалить</a></li>
          </ul>
        </div>
<?php } ?>
      </div>
      <div v-if="data.deleting">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
        </div>
        Удаление...
      </div>
<?php } ?>
    </div>
    <div class="card-body p-0">
      <table class="table mb-0 table-sm">
        <tbody>
          <tr>
            <td class="px-3 col-md-4 col-lg-3">Коротая метка</td>
            <td class="px-3">{{data.tag}}</td>
          </tr>
          <tr>
            <td class="px-3 col-md-4 col-lg-3">Название</td>
            <td class="px-3">{{data.name}}</td>
          </tr>
          <tr>
            <td class="px-3 col-md-4 col-lg-3">Описание</td>
            <td class="px-3 text-break">{{data.comment}}</td>
          </tr>
          <tr>
            <td class="px-3 col-md-4 col-lg-3">Права роли</td>
            <td class="px-3">
<?php foreach (Module('permissions')->execute('list') as $permission => $data) { ?>
              <div class="form-check" style="margin-left: <?=substr_count($permission, '.') * 1.75?>rem;">
                <input class="form-check-input" type="checkbox" id="v_<?=$permission?>" v-model="data.permissions['<?=$permission?>']" disabled>
                <label class="form-check-label" for="v_<?=$permission?>">
                  <?=$data['name']?>
                </label>
              </div>
<?php } ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
<?php if ($enableEdit) { ?>
  <role-information-edit-dialog></role-information-edit-dialog>
<?php } ?>
</script>
<?php
Layout()->endGrab();
?>
<role-information-view-form>
  <div class="text-center text-body-secondary">
    <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
    Загрузка...
  </div>
</role-information-view-form>

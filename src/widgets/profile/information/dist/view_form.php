<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();
$enableEdit = $this->param('enableEdit');

RequireLib('vue3');
RequireLib('toast');
RequireLib('confirm');
RequireLib('project/contacts');

if ($enableEdit) {
    $this->include(__dir('edit_dialog.php'));
}

Layout()->append('body.js.code', file_get_contents(__dir('view_controller.js')));

Layout()->startGrab('body.content.end');

?>
<script type="text/html" id="profileInformationViewForm">
  <div class="card">
    <div class="card-header py-1 d-flex justify-content-between align-middle">
      <div><i class="bi bi-info-circle me-1"></i>Свойства</div>
<?php if ($enableEdit) { ?>
      <div v-if="!data.deleting" class="btn-group" role="group">
        <button class="btn btn-default btn-sm py-0" @click="edit(data)"><i class="bi bi-pencil me-1"></i>Изменить</button>
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-default btn-sm py-0 px-1 text-muted" data-bs-toggle="dropdown">
            <i class="bi bi-caret-down-fill small"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#" @click.prevent="remove(data)"><i class="bi bi-trash me-1"></i>Удалить</a></li>
          </ul>
        </div>
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
            <td class="px-3 col-md-4 col-lg-3">Имя</td>
            <td class="px-3">{{data.name.full}}</td>
          </tr>
          <tr>
            <td class="px-3">Должность</td>
            <td class="px-3">{{data.post}}</td>
          </tr>
          <tr>
            <td class="px-3">Контакты</td>
            <td class="px-3"><contacts-view :list="data.contacts" /></td>
          </tr>
          <tr>
            <td class="px-3">Заметки</td>
            <td class="px-3" style="white-space: pre-wrap">{{data.comment}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
<?php if ($enableEdit) { ?>
  <profile-information-edit-dialog></profile-information-edit-dialog>
<?php } ?>
</script>
<?php
Layout()->endGrab();
?>
<profile-information-view-form>
  <div class="text-center text-muted">
    <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
    Загрузка...
  </div>
</profile-information-view-form>

<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();
$enableEdit = $this->param('enableEdit');

RequireLib('vue3');
RequireLib('toast');
RequireLib('confirm');

if ($enableEdit) {
    $this->include(__dir('edit_dialog.php'));
}

Layout()->append('body.js.code', file_get_contents(__dir('view_controller.js')));

Layout()->startGrab('body.content.end');

?>
<script type="text/html" id="examplesEmployeeInformationViewForm">
  <div class="card">
    <div class="card-header py-1 d-flex justify-content-between align-middle">
      <div><i class="bi bi-info-circle me-1"></i>Свойства</div>
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
    </div>
    <div class="card-body p-0">
      <table class="table mb-0 table-sm">
        <tbody>
          <tr>
            <td class="px-3 col-md-4 col-lg-3">ФИО</td>
            <td class="px-3">{{data.name}}</td>
          </tr>
          <tr>
            <td class="px-3 col-md-4 col-lg-3">Должность</td>
            <td class="px-3">{{data.post}}</td>
          </tr>
          <tr>
            <td class="px-3 col-md-4 col-lg-3">Обязанности</td>
            <td class="px-3 text-break">{{data.responsibilities}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
<?php if ($enableEdit) { ?>
  <examples-employee-information-edit-dialog></examples-employee-information-edit-dialog>
<?php } ?>
</script>
<?php
Layout()->endGrab();
?>
<examples-employee-information-view-form></examples-employee-information-view-form>

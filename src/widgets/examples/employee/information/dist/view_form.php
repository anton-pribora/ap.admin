<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Examples\Employee */

$record = $this->argument();
$enableEdit = $this->param('enableEdit');

RequireLib('vue3');
RequireLib('toast');
RequireLib('confirm');
RequireLib('file-uploader');

Widget('info::enable');

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
        <button type="button" class="btn btn-default btn-sm py-0 px-1 text-muted" data-bs-toggle="dropdown">
          <i class="bi bi-caret-down-fill small"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#" @click.prevent="remove(data)"><i class="bi bi-trash me-1"></i>Удалить</a></li>
        </ul>
      </div>
      <div v-if="data.deleting">
        <div class="spinner-border spinner-border-sm text-primary" role="status">
        </div>
        Удаление...
      </div>
    </div>
    <div class="card-body px-0 py-2 pb-3">
      <div class="row">
        <div class="col-3 text-center">

          <a v-if="data.avatar" href="" @click.prevent="viewAvatar(data.avatar)" class="">
            <img :src="data.avatar.url" class="m-2 img-fluid rounded" width="100" alt="Avatar">
          </a>
          <svg v-if="!data.avatar" class="bd-placeholder-img m-2 img-fluid rounded" width="100" height="100" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect></svg>

          <div class="mt-1">
            <div class="btn-group" role="group">
              <button :disabled="data.avatarDeleting" class="btn btn-default btn-sm py-1" @click="uploadAvatar(data)" title="Загрузить фото"><i class="bi bi-upload me-1"></i>Загрузить</button>
              <button :disabled="data.avatarDeleting" type="button" class="btn btn-default btn-sm py-1 px-2 text-muted" data-bs-toggle="dropdown">
                <i class="bi bi-caret-down-fill small"></i>
              </button>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" @click.prevent="removeAvatar(data)"><i class="bi bi-trash me-1"></i>Удалить</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col">
          <table class="table mb-0 table-sm">
            <tbody>
              <tr>
                <td class="pe-3 col-md-4 col-lg-3">ФИО</td>
                <td class="px-3">{{data.name}}</td>
              </tr>
              <tr>
                <td class="pe-3 col-md-4 col-lg-3">Должность</td>
                <td class="px-3">{{data.post}}</td>
              </tr>
              <tr>
                <td class="pe-3 col-md-4 col-lg-3">Обязанности</td>
                <td class="px-3 text-break">{{data.responsibilities}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
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

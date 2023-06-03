<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();

$enableEdit   = $this->param('enableEdit');
$enableRemove = $this->param('enableRemove');

RequireLib('vue3');
RequireLib('toast');
RequireLib('confirm');
RequireLib('project/contacts');
RequireLib('file-uploader');

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
      <div class="row">
        <div class="col-xl-3">
          <div class="card m-2 text-center">
            <div class="card-body p-1">
            <a v-if="data.photo.large" :href="data.photo.large.url" target="_blank">
              <img :src="data.photo.small.url" class="img-fluid" :width="data.photo.small.width" :height="data.photo.small.height">
            </a>
            <img v-else :src="data.photo.small.url" class="img-fluid" :width="data.photo.small.width" :height="data.photo.small.height">
            </div>
          </div>
          <div class="d-flex justify-content-center mb-2">
<?php if ($enableEdit) { ?>
            <div v-if="!photoDeleting" class="btn-group" role="group">
              <button class="btn btn-default py-0" @click="pickPhotoAndUpload()"><i class="bi bi-upload me-1"></i>Загрузить</button>
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-default py-0 px-1 text-body-secondary" data-bs-toggle="dropdown">
                  <i class="bi bi-caret-down-fill small"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end py-1 shadow">
                  <li><a class="dropdown-item" href="#" @click.prevent="removePhoto()"><i class="bi bi-trash me-1"></i>Удалить</a></li>
                </ul>
              </div>
            </div>
            <div v-if="photoDeleting">
              <div class="spinner-border spinner-border-sm text-primary" role="status">
              </div>
              Удаление...
            </div>
<?php } ?>
          </div>

        </div>
        <div class="col-xl-9 ms-0 ps-xl-0">
          <table class="table mb-0 table-sm">
            <tbody>
              <tr>
                <td class="pe-xl-3 ps-xl-0 ps-2 col-md-4 col-lg-3">Имя</td>
                <td class="px-xl-3">{{data.name.full}}</td>
              </tr>
              <tr>
                <td class="pe-xl-3 ps-xl-0 ps-2">Должность</td>
                <td class="px-xl-3">{{data.post}}</td>
              </tr>
              <tr>
                <td class="pe-xl-3 ps-xl-0 ps-2">Контакты</td>
                <td class="px-xl-3"><contacts-view :list="data.contacts" /></td>
              </tr>
              <tr>
                <td class="pe-xl-3 ps-xl-0 ps-2">Заметки</td>
                <td class="px-xl-3" style="white-space: pre-wrap">{{data.comment}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
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
  <div class="text-center text-body-secondary">
    <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
    Загрузка...
  </div>
</profile-information-view-form>

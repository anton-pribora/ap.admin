<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();
$enableEdit = $this->param('enableEdit');

RequireLib('vue3');
RequireLib('confirm');
RequireLib('file-uploader');

if ($enableEdit) {
    $this->include(__dir('edit_dialog.php'));
}

Layout()->append('body.js.code', file_get_contents(__dir('view_controller.js')));
Layout()->startGrab('body.content.end');
?>
<script type="text/html" id="profileFilesViewForm">
  <div class="card">
    <div class="card-header py-1 d-flex justify-content-between align-middle">
      <div>
        <i class="bi bi-files me-1"></i>Файлы
        <div v-if="loading" class="spinner-border spinner-border-sm text-primary" role="status">
          <span class="visually-hidden">Загрузка...</span>
        </div>
      </div>
<?php if ($enableEdit) { ?>
      <button class="btn btn-default btn-sm py-0" @click="pickAndUpload"><i class="bi bi-upload me-1"></i>Загрузить</button>
<?php } ?>
    </div>
    <div style="overflow-x: auto">
    <file-dropzone @drop="upload" class-name="widget-body">
      <table class="table table-hover mb-0" style="">
        <thead>
        <tr>
          <th>#</th>
          <th>Дата</th>
          <th>Название</th>
          <th>Размер</th>
          <th>Комментарий</th>
<?php if ($enableEdit) { ?>
          <th>Управление</th>
<?php } ?>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(e, i) in filtered">
          <td>
            {{i + 1 + pager.page * pager.limit}}
          </td>
          <td>
            {{e.createdAt.formatted}}
          </td>
          <td>
            <a :href="e.url.view" target="_blank"><span v-html="e.mime.icon"></span>{{e.name}}<i class="bi bi-box-arrow-up-right ms-2"></i></a>
          </td>
          <td>
            {{e.size.formatted}}
          </td>
          <td>
            {{e.comment}}
          </td>
<?php if ($enableEdit) { ?>
          <td class="text-end">
            <div class="btn-group btn-group-sm" v-if="!e.deleting">
              <button class="btn btn-default" @click="edit(e)"><i class="bi bi-pencil me-1"></i>Изменить</button>
              <button type="button" class="btn btn-default btn-sm py-0 px-1 text-body-secondary" data-bs-toggle="dropdown">
                <i class="bi bi-caret-down-fill small"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#" @click.prevent="remove(e)"><i class="bi bi-trash me-1"></i>Удалить</a></li>
              </ul>
            </div>

            <div v-if="e.deleting">
              <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
              Удаление...
            </div>
          </td>
<?php } ?>
        </tr>
        </tbody>
      </table>
      <div v-if="filtered.length === 0" class="m-3">
        <div class="text-center text-body-secondary">(Нет данных)</div>
      </div>
    </file-dropzone>
    </div>
<?php Template()->render('@extra/widget/list-footer.php');?>
  </div>
<?php if ($enableEdit) { ?>
  <profile-files-edit-dialog></profile-files-edit-dialog>
<?php } ?>
</script>
<?php
Layout()->endGrab();
?>
<profile-files-view-form>
  <div class="text-center text-body-secondary">
    <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
    Загрузка...
  </div>
</profile-files-view-form>

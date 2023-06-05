<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

$record = $this->argument();
$enableEdit = $this->param('enableEdit');

RequireLib('vue3');
RequireLib('toast');

if ($enableEdit) {
    $this->include(__dir('edit_dialog.php'));
}

Layout()->append('body.js.code', file_get_contents(__dir('view_controller.js')));

Layout()->startGrab('body.content.end');

?>
<script type="text/html" id="profilePasswordViewForm">
  <div class="card">
    <div class="card-header py-1 d-flex justify-content-between align-middle">
      <div><i class="bi bi-key me-1"></i>Данные для входа</div>
<?php if ($enableEdit) { ?>
      <div class="btn-group" role="group">
        <button class="btn btn-default btn-sm py-0" @click="edit(data)"><i class="bi bi-pencil me-1"></i>Изменить</button>
      </div>
<?php } ?>
    </div>
    <table class="table mb-0">
      <tr>
        <td class="ps-3 pe-2 col-5">Логин</td>
        <td class="ps-2 pe-3">{{data.login ? '*******' : ''}}</td>
      </tr>
      <tr>
        <td class="ps-3 pe-2">Пароль</td>
        <td class="ps-2 pe-3">{{data.login ? '*******' : ''}}</td>
      </tr>
      <tr>
        <td class="ps-3 pe-2">Последний вход</td>
        <td class="ps-2 pe-3">{{data.last_usage.formatted}}</td>
      </tr>
    </table>
  </div>
<?php if ($enableEdit) { ?>
  <profile-password-edit-dialog></profile-password-edit-dialog>
<?php } ?>
</script>
<?php
Layout()->endGrab();
?>
<profile-password-view-form>
  <div class="text-center text-muted">
    <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
    Загрузка...
  </div>
</profile-password-view-form>

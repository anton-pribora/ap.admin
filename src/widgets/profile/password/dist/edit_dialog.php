<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

RequireLib('vue3');

$record = $this->argument();
$enableEdit = $this->param('enableEdit');

$full    = $enableEdit === 'full';
$partial = $enableEdit === 'partial';

// Включаем автозаполнение только если пользователь редактирует сам свою запись
$enableAutocomplete = $record->id() == Identity()->getId();

Layout()->append('body.js.code', file_get_contents(__dir('edit_controller.js')));

Layout()->startGrab('body.content.end');
?>
<script type="text/html" id="profilePasswordEditDialog">
  <div class="modal fade" tabindex="-1" ref="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <form @submit.prevent="save">
          <fieldset :disabled="loading" @change="onChange">
            <div class="modal-header">
              <h5 class="modal-title">Изменить данные для входа</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
<?php if ($full) { ?>
              <div class="mb-3 row">
                <label class="col-sm-4 col-form-label text-end">Логин</label>
                <div class="col-auto">
                  <input type="text" class="form-control" v-model="data.login" autocomplete="<?=$enableAutocomplete ? 'current-login' : 'off'?>">
                </div>
              </div>
<?php } ?>
<?php if ($partial) { ?>
              <div class="mb-3 row">
                <label class="col-sm-4 col-form-label text-end">Логин</label>
                <div class="col-auto">
                  <div class="col-form-label">{{data.login}}</div>
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-sm-4 col-form-label text-end">Текущий пароль</label>
                <div class="col-auto">
                  <input type="password" class="form-control" v-model="oldPassword" autocomplete="<?=$enableAutocomplete ? 'current-password' : 'off'?>">
                </div>
              </div>
<?php } ?>
              <hr />
              <div class="mb-3 row">
                <label class="col-sm-4 col-form-label text-end">Новый пароль</label>
                <div class="col-auto ">
                  <input type="password" class="form-control" v-model="newPassword" autocomplete="<?=$enableAutocomplete ? 'new-password' : 'off'?>">
                </div>
              </div>
              <div class="mb-3 row">
                <label class="col-sm-4 col-form-label text-end">Подтверждение</label>
                <div class="col-auto">
                  <input type="password" class="form-control" v-model="confirmPassword" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                <i class="bi bi-x-lg text-danger"></i>
                Отменить
              </button>
              <button type="submit" class="btn btn-default">
                <div v-if="loading" class="spinner-border spinner-border-sm text-primary" role="status">
                  <span class="visually-hidden">Загрузка...</span>
                </div>
                <i v-if="!loading" class="bi bi-check-lg text-success"></i>
                Сохранить
              </button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</script>
<?php
Layout()->endGrab();

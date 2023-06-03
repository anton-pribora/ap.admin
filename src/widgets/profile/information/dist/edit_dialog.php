<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

RequireLib('vue3');
RequireLib('toast');
RequireLib('project/contacts');

Layout()->append('body.js.code', file_get_contents(__dir('edit_controller.js')));

Layout()->startGrab('body.content.end');
?>
<script type="text/html" id="profileInformationEditDialog">
  <div class="modal fade" tabindex="-1" ref="modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent="save">
          <fieldset :disabled="loading" @change="onChange">
            <div class="modal-header">
              <h5 class="modal-title">Изменить свойства</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">ФИО</label>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col">
                      <div class="form-floating">
                        <input type="text" class="form-control" v-model="data.name.last" id="name.last">
                        <label for="name.last">Фамилия</label>
                      </div>
                    </div>
                    <div class="col">
                    <div class="form-floating">
                      <input type="text" class="form-control" v-model="data.name.first" id="name.first">
                      <label for="name.first">Имя</label>
                    </div>
                    </div>
                     <div class="col">
                   <div class="form-floating">
                      <input type="text" class="form-control" v-model="data.name.middle" id="name.middle">
                      <label for="name.middle">Отчество</label>
                    </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Должность</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" v-model="data.post">
                </div>
              </div>

              <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Контакты</label>
                <div class="col-sm-10"><contacts-edit :list="data.contacts" @change="onChange"/></div>
              </div>

              <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Заметки</label>
                <div class="col-sm-10">
                  <textarea class="form-control" v-model="data.comment"></textarea>
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

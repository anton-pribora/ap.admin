<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

RequireLib('vue3');

Layout()->append('body.js.code', file_get_contents(__dir('edit_controller.js')));

Layout()->startGrab('body.content.end');
?>
<script type="text/html" id="profileRolesEditDialog">
  <div class="modal fade" tabindex="-1" ref="modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent="save">
          <fieldset :disabled="loading" @change="onChange">
            <div class="modal-header">
              <h5 class="modal-title">Изменить права и роли</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Роли</label>
                <div class="col-sm-10">
                  <template v-for="(e, tag) in data.roles">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" v-model="e.checked">
                        {{e.name}}
                      </label>
                      <span class="text-muted"> &mdash; {{e.comment}}</span>
                    </div>
                    <div v-if="e.checked && e.sublist" class="ms-4">
                      <div class="form-check" v-for="f in e.sublist">
                        <label class="form-check-label">
                          <input class="form-check-input" type="checkbox" v-model="f.checked">
                          {{f.name}}
                        </label>
                      </div>
                    </div>
                  </template>
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

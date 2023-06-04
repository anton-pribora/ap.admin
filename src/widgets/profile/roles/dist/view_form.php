<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record Project\Profile */

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
<script type="text/html" id="profileRolesViewForm">
  <div class="card">
    <div class="card-header py-1 d-flex justify-content-between align-middle">
      <div><i class="bi bi-unlock me-1"></i>Права и роли</div>
<?php if ($enableEdit) { ?>
      <div class="btn-group" role="group">
        <button class="btn btn-default btn-sm py-0" @click="edit(data)"><i class="bi bi-pencil me-1"></i>Изменить</button>
      </div>
<?php } ?>
    </div>
    <div class="card-body p-0">
      <table class="table mb-0 table-sm">
        <tbody>
          <tr>
            <td class="px-3 col-md-4 col-lg-3">Роли</td>
            <td class="px-3">
              <ul class="list-unstyled mb-0">
                <template v-for="(e, tag) in data.roles">
                  <li v-if="e.checked">
                    <i class="bi me-2" :class="{'bi-check-square': e.checked, 'bi-square': !e.checked}"></i>
                    <abbr :title="e.comment">{{e.name}}</abbr>
                    <ul v-if="e.sublist" class="list-unstyled ms-4">
                      <template v-for="f in e.sublist">
                      <li v-if="f.checked">
                        <i class="bi me-2" :class="{'bi-check-square': f.checked, 'bi-square': !f.checked}"></i>
                        {{f.name}}
                      </li>
                      </template>
                    </ul>
                  </li>
                </template>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
<?php if ($enableEdit) { ?>
  <profile-roles-edit-dialog></profile-roles-edit-dialog>
<?php } ?>
</script>
<?php
Layout()->endGrab();
?>
<profile-roles-view-form>
  <div class="text-center text-muted">
    <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
    Загрузка...
  </div>
</profile-roles-view-form>

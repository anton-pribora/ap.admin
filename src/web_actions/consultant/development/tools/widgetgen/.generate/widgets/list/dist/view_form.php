<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$th = [];
$td = [];

foreach ($this->param('fields') as ['prop' => $prop, 'title' => $title, 'view' => $view, 'format' => $format]) {
    if ($view) {
        $th[] = <<<HTML
        <th>{$title}</th>
HTML;

        $td[] = <<<HTML
        <td>
          {{e.{$prop}}}
        </td>
HTML;
    }
}

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

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
<script type="text/html" id="{$templateId}">
  <div class="card">
    <div class="card-header py-1 d-flex justify-content-between align-middle">
      <div>
        <i class="bi bi-files me-1"></i>Элементы
        <div v-if="loading" class="spinner-border spinner-border-sm text-primary" role="status">
          <span class="visually-hidden">Загрузка...</span>
        </div>
      </div>
<?php if ($enableEdit) { ?>
      <button class="btn btn-default btn-sm py-0" @click="edit({})"><i class="bi bi-plus-lg me-1"></i>Добавить</button>
<?php } ?>
    </div>
    <table class="table table-hover mb-0" style="">
      <thead>
      <tr>
        <th>#</th>
        {$th}
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
        {$td}
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

<?php Template()->render('@extra/widget/list-footer.php');?>
  </div>
<?php if ($enableEdit) { ?>
  <{$editDialog}></{$editDialog}>
<?php } ?>
</script>
<?php
Layout()->endGrab();
?>
<{$viewForm}>
  <div class="text-center text-body-secondary">
    <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
    Загрузка...
  </div>
</{$viewForm}>

PHP;

$data = strtr($data, [
    '{$billetClass}' => $this->param('part.billet'),
    '{$templateId}'  => $this->param('widget.templateId.viewForm'),
    '{$editDialog}'  => $this->param('widget.component.editDialog'),
    '{$viewForm}'    => $this->param('widget.component.viewForm'),
    '{$th}'          => ltrim(join("\n", $th)),
    '{$td}'          => ltrim(join("\n", $td)),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

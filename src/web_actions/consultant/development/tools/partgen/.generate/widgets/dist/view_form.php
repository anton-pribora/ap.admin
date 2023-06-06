<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$rows = [];

foreach ($this->param('fields') as ['prop' => $prop, 'title' => $title, 'view' => $view, 'format' => $format]) {
    if ($view) {
        if ($format === 'text') {
            $rows[] = <<<PHP
          <tr>
            <td class="px-3 col-md-4 col-lg-3">{$title}</td>
            <td class="px-3 text-break">{{data.{$prop}}}</td>
          </tr>
PHP;
        } else {
            $rows[] = <<<PHP
          <tr>
            <td class="px-3 col-md-4 col-lg-3">{$title}</td>
            <td class="px-3">{{data.{$prop}}}</td>
          </tr>
PHP;
        }
    }
}

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

$record       = $this->argument();
$enableEdit   = $this->param('enableEdit');
$enableRemove = $this->param('enableRemove');

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
      <table class="table mb-0 table-sm">
        <tbody>
          {$rows}
        </tbody>
      </table>
    </div>
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
    '{$rows}'        => ltrim(join("\n", $rows)),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

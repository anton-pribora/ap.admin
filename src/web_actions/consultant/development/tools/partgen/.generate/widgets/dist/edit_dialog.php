<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$rows = [];

foreach ($this->param('fields') as ['prop' => $prop, 'title' => $title, 'view' => $view, 'format' => $format]) {
    if ($view) {
        if ($format === 'text') {
            $rows[] = <<<PHP
              <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">{$title}</label>
                <div class="col-sm-10">
                  <textarea type="text" rows="3" class="form-control" v-model="data.{$prop}"></textarea>
                </div>
              </div>
PHP;
        } else {
            $rows[] = <<<PHP
              <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">{$title}</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" v-model="data.{$prop}">
                </div>
              </div>
PHP;
        }
    }
}

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

RequireLib('vue3');

Layout()->append('body.js.code', file_get_contents(__dir('edit_controller.js')));

Layout()->startGrab('body.content.end');
?>
<script type="text/html" id="{$editDialogTemplate}">
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
              {$rows}
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

PHP;

$data = strtr($data, [
    '{$billetClass}'        => $this->param('part.billet'),
    '{$editDialogTemplate}' => $this->param('widget.templateId.editDialog'),
    '{$rows}'               => ltrim(join("\n", $rows)),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

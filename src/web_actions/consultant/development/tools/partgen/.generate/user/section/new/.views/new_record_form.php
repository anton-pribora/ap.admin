<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$fields = $this->param('fields');

$rows = [];

foreach ($fields as ['edit' => $edit, 'prop' => $prop, 'title' => $title, 'format' => $fomat]) {
    if ($edit) {
        if ($fomat === 'text') {
            $rows[] = <<<PHP
  <div class="row mb-3">
    <label for="input.{$prop}" class="col-sm-2 col-form-label text-end">{$title}</label>
    <div class="col-sm-10">
      <textarea class="form-control" rows="3" name="{$prop}" id="input.{$prop}"><?=Html(\$value('{$prop}'))?></textarea>
    </div>
  </div>
PHP;
        } else {
            $rows[] = <<<PHP
  <div class="row mb-3">
    <label for="input.{$prop}" class="col-sm-2 col-form-label text-end">{$title}</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="{$prop}" id="input.{$prop}" value="<?=Html(\$value('{$prop}'))?>">
    </div>
  </div>
PHP;
        }
    }
}

$data = <<<'PHP'
<?php

/* @var $this ApCode\Template\Template */


$data = $this->argument(0, []);

$value = function ($name, $default = null) use ($data) {
    return isset($data[$name]) ? $data[$name] : $default;
};

?>
<form method="post" action="">
  {$rows}
  <div class="text-end">
    <button type="submit" class="btn btn-default" name="action" value="save"
            onclick="document.querySelector('#loader').className='spinner-border text-primary spinner-border-sm'; setTimeout(() => this.disabled = true)"
    >
      <i id="loader" class="bi bi-check-lg text-success"></i> Сохранить
    </button>
  </div>
</form>

PHP;

$data = strtr($data, [
    '{$rows}' => trim(join("\n", $rows))
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

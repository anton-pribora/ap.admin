<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");;

$fields = $this->param('fields');

$inputs = [];

foreach ($fields as ['prop' => $prop, 'title' => $title, 'search' => $search, 'view' => $view]) {
    if ($search && $view) {
        $value =
        $inputs[] = <<<PHP
  <div class="col-12">
    <label class="visually-hidden" for="inlineFormInput-{$prop}">{$title}</label>
    <input type="text" class="form-control" id="inlineFormInput-{$prop}" placeholder="{$title}" value="<?php echo Html(\$this->param('{$prop}'))?>" name="{$prop}">
  </div>
PHP;
    }
}

$inputs = join('', $inputs);

$data = <<<PHP
<form class="row row-cols-lg-auto g-2 mb-3 align-items-center">
<?php
foreach (Url()->getStaticParams() as \$name => \$value) {
    echo new ApCode\Html\Element\Input(\$value, \$name, 'hidden');
}
?>
$inputs
  <div class="col-12">
    <button type="submit" class="btn btn-default">Найти</button>
  </div>
</form>

PHP;

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");;

$fields      = $this->param('fields');
$billetClass = $this->param('part.billet');

$body = '';

$i = 0;

foreach ($fields as ['view' => $view, 'getter' => $getter, 'prop' => $prop, 'title' => $title]) {
    if ($view && $getter !== 'name') {
        $prop = ucfirst($prop);
        $body .= "        <div><span class=\"text-body-secondary\">{$title}:</span> <?=Html(\$item->{$getter}())?></div>\n";

        if (++$i >= 3) {
            break;
        }
    }
}

$data = <<<PHP
<?php

/* @var \$this ApCode\Template\Template */
/* @var \$list {$billetClass}[] */

\$list = \$this->argument(0);
\$startFrom = \$this->argument(1);

foreach (\$list as \$i => \$item) {
?>
<div class="mb-3">
  <div class="d-flex align-items-stretch">
    <div style="min-width: 80px">
      <svg class="bd-placeholder-img img-fluid rounded" width="80" height="80" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#868e96"></rect></svg>
    </div>
    <div class="flex-fill">
      <div class="ms-3">
        <h5 class="card-title"><?=\$item->urlAsset('link.view')?> <small class="text-body-secondary ms-3">#<?=\$item->id()?></small></h5>
{$body}
      </div>
    </div>
  </div>
</div>
<?php
}

PHP;

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

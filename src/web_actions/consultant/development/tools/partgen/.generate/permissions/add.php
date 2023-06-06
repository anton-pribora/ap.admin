<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Project\Profile */

$consultant = $this->argument(0);

return true;

PHP;

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

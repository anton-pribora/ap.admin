<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Project\Profile */
/* @var $record {$billetClass} */

$consultant = $this->argument(0);
$record = $this->argument(1);

return true;

PHP;

$data = strtr($data, [
    '{$billetClass}' => $this->param('part.billet'),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

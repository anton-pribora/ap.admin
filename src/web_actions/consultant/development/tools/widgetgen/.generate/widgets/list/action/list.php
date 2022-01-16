<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

use ApCode\Codebuilder\PhpValueArray;
use ApCode\Codebuilder\PhpValueRawCode;

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$billetClass = $this->param('part.billet');

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

$record = $this->argument();

ReturnJson($this->include('encodeList.php'));


PHP;

$data = strtr($data, [
    '{$billetClass}' => $billetClass,
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

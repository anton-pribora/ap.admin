<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

use ApCode\Codebuilder\PhpValueArray;
use ApCode\Codebuilder\PhpValueRawCode;

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

$record = $this->argument();

$result = [];

foreach (range(1, 10) /*$record->items()*/ as $i => $item) {
    $result[] = $this->execute('encodeData.php', $item) + ['id' => $i + 1];
}

return $result;

PHP;

$data = strtr($data, [
    '{$billetClass}' => $this->param('part.billet'),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

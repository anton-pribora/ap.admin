<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

use ApCode\Codebuilder\PhpValueArray;
use ApCode\Codebuilder\PhpValueRawCode;

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$props = [];

foreach ($this->param('fields') as ['prop' => $prop, 'title' => $title, 'getter' => $getter, 'view' => $view]) {
    if ($view || $prop === 'id') {
        $props[$prop] = new PhpValueRawCode("'$prop',  // \$record->{$getter}()");
    }
}

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

$record = $this->argument();

return {$props};

PHP;

$data = strtr($data, [
    '{$billetClass}' => $this->param('part.billet'),
    '{$props}'       => (new PhpValueArray($props))->render('    '),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

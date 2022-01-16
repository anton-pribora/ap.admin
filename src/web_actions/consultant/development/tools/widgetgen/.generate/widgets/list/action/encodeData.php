<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

use ApCode\Codebuilder\PhpValueArray;
use ApCode\Codebuilder\PhpValueRawCode;

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$billetClass = $this->param('part.billet');
$fields = $this->param('fields');

$props = [];

foreach ($fields as ['prop' => $prop, 'getter' => $getter, 'view' => $view]) {
    if ($view || $prop === 'id') {
        $props[$prop] = new PhpValueRawCode("'{$prop}', // \$record->{$getter}()");
    }
}

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass}Item */

$record = $this->argument();

return {$props};

PHP;

$data = strtr($data, [
    '{$billetClass}' => $billetClass,
    '{$props}'       => (new PhpValueArray($props))->render('    '),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

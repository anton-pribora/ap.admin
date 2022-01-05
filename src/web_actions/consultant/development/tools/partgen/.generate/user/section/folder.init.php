<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$name = $this->param('part.name');

$data = <<<PHP
<?php

use ApCode\Html\Element\A;

Layout()->setVar('title', '$name');
Layout()->append('breadcrumbs', new A('$name', ShortUrl(__dir('/'))));

PHP;

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

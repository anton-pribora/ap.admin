<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$recordKey = $this->param('part.key');
$billetClass = $this->param('part.billet');

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

$record = $this->param('record');

$params = [
    '{$recordKey}.edit' => Identity()->hasPermit('{$recordKey}.edit', $record),
];

Module('widgets')->execute('handle.php', $record, $params);

$menu = [];

//Template()->render('@extra/nav-tabs.php', Meta(__DIR__)->get('nav', []));
//Template()->render('@extra/list-inline.php', $menu);
Template()->render(__dir('.views/view.php'), $record, $params);

PHP;

$data = strtr($data, [
    '{$recordKey}'   => $recordKey,
    '{$billetClass}' => $billetClass,
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}
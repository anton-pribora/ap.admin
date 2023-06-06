<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $record {$billetClass} */

$record = $this->param('record');

$params = [
    '{$recordKey}.edit'   => Identity()->getPermit('{$recordKey}.edit', $record),
    '{$recordKey}.remove' => Identity()->getPermit('{$recordKey}.remove', $record),
];

Module('widgets')->execute('handle.php', $record, $params);

$menu = [
    Module('project')->execute('history/button.php', ['section' => $record->historySection(), 'recordId' => $record->id(), 'viewAll' => true]),
];

//Template()->render('@extra/nav-tabs.php', Meta(__DIR__)->get('nav', []));
Template()->render('@extra/list-inline.php', $menu);
Template()->render(__dir('.views/view.php'), $record, $params);

PHP;

$data = strtr($data, [
    '{$billetClass}' => $this->param('part.billet'),
    '{$recordKey}'   => $this->param('part.key'),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

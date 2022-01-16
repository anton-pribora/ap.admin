<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$fileName = basename(__FILE__);
$this->param('printIndent')("{$fileName} ... ");

$data = <<<'PHP'
<?php

/* @var $this ApCode\Executor\RuntimeInterface */

$record = {$billetClass}::getInstance(Request()->get('{$recordIdKey}'));

// Запись не найдена
if (empty($record->id())) {
    Redirect(ShortUrl(dirname(__DIR__) . '/'));
}

Url()->makeStaticParam('{$recordIdKey}');

$this->setParam('record', $record);

PathAlias()->append('~/', basename(__DIR__) .'/');

Layout()->setVar('title', $record->name());
Layout()->append('breadcrumbs', $record->urlAsset('link.view'));

PHP;

$data = strtr($data, [
    '{$billetClass}' => $this->param('part.billet'),
    '{$recordIdKey}' => $this->param('part.recordIdKey'),
]);

$fullPath = "{$this->param('cwd')}/{$fileName}";

if ($this->param('makeFile')($fullPath, $data)) {
    $this->param('printOk')();
}

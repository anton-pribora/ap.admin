<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$this->param('printIndent')("Пункт меню ... ");

if (!$this->param('part.menu')) {
    $this->param('print')("пропущен (не стоит галочка)\n");
    return;
}

$cwd  = $this->param('cwd');
$name = $this->param('part.name');
$path = $this->param('part.path');

$data = <<<PHP
'menu' => [
        ['text' => '$name', 'url' => ShortUrl('$path/'), 'submenu' => [
            ['text' => Icon('search') . 'Все', 'url' => ShortUrl('$path/')],
        ]],
PHP;

$metaFile = ExpandPath($this->param('part.menuFile'));

if (!file_exists($metaFile)) {
    $this->param('print')("пропущен (нет файла с мета-данными {$metaFile})\n");
    return;
}

$meta = file_get_contents($metaFile);

if (strpos($meta, $path) > -1) {
    $this->param('print')("пропущен (уже добавлен)\n");
    return;
}

$newMeta = str_replace("'menu' => [", $data, $meta, $count);

if ($count <= 0) {
    $this->param('print')("ошибка (не удалось найти место для добавления нового пункта)\n");
    return;
}

if ($this->param('makeFile')($metaFile, (string) $newMeta, true)) {
    $this->param('print')("добавлен\n");
};

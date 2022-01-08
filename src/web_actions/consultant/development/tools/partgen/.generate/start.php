<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$setIndent = function ($value) {
    $this->setParam('indent', $value);
};

$getIndent = function () {
    return $this->param('indent', 0);
};

$increaseIndent = function () use ($getIndent, $setIndent) {
    $setIndent($getIndent() + 2);
};

$decreaseIndent = function () use ($getIndent, $setIndent) {
    $setIndent($getIndent() - 2);
};

$print = function (...$data) {
    echo join('', $data);
};

$printOk = function () use ($print) {
    $print("ок\n");
};

$printIndent = function ($text) use ($getIndent, $print) {
    $print(str_repeat(' ', $getIndent()), $text);
};

$startSection = function ($name) use ($printIndent, $increaseIndent) {
    $printIndent($name . "\n");
    $increaseIndent();
};

$endSection = function () use ($decreaseIndent) {
    $decreaseIndent();
};

$globInclude = function ($pattern, $flags = 0) use ($increaseIndent) {
    foreach (glob($pattern, $flags) as $file) {
        $this->include($file);
    }
};

$makeDir = function ($fullPath) use ($print) {
    if (!file_exists($fullPath)) {
        if (!mkdir($fullPath, 0755, true)) {
            $print("ошибка (не удалось создать директорию $fullPath)\n");
            return false;
        }
    }

    return true;
};

$makeFile = function ($fullPath, $data) use ($makeDir, $print) {
    $baseFolder = $this->param('baseFolder');

    if ($baseFolder) {
        $fullPath = substr_replace($fullPath, $baseFolder, 0, strlen(ROOT_DIR));
    }

    if (file_exists($fullPath)) {
        if (!is_writable($fullPath)) {
            $print("ошибка (файл $fullPath не доступен для записи)\n");
            return false;
        }
    }

    if (!$makeDir(dirname($fullPath))) {
        return false;
    }

    return (bool) file_put_contents($fullPath, $data);
};

$this->setParam('startSection', $startSection);
$this->setParam('endSection', $endSection);
$this->setParam('makeFile', $makeFile);
$this->setParam('globInclude', $globInclude);
$this->setParam('print', $print);
$this->setParam('printIndent', $printIndent);
$this->setParam('printOk', $printOk);

if ($this->param('generate.classes')) {
    $startSection("Генерируем классы:");
    $this->setParam('cwd', ExpandPath('@root/classes'));
    $globInclude(__dir('classes/*.php'));
    $endSection();
}

if ($this->param('generate.permissions')) {
    $startSection("Генерируем права доступа:");
    $this->setParam('cwd', ExpandPath('@root/permissions/' . strtr($this->param('permissions.path'), ['.' => '/'])));
    $globInclude(__dir('permissions/*.php'));
    $endSection();
}

if ($this->param('generate.widget')) {
    $startSection("Генерируем виджеты:");
    $this->setParam('cwd', ExpandPath('@widgets/' . strtr($this->param('widget.path'), ['.' => '/']) . '/' . $this->param('widget.name')));
    $globInclude(__dir('widgets/*.php'));
    $endSection();
}

if ($this->param('generate.section')) {
    $startSection("Генерируем раздел пользователя:");
    $this->setParam('cwd', ExpandPath($this->param('part.path')));
    $globInclude(__dir('user/*.php'));
    $endSection();
}

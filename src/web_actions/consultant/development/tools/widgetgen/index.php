<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

RequireLib('vue3');
RequireLib('toast');

Layout()->setVar('title', 'Генератор виджетов');

$action = Request()->get('action');

$disableZip = false;
$disableHdd = false;

if (!extension_loaded('zip')) {
    $disableZip = true;
    Alert('Не установлено расширение <strong>zip</strong>. Скачивание архива недоступно.');
}

if (Config()->get('APPLICATION_ENV') !== 'development') {
    $disableHdd = true;
    Alert('Вы находитесь на окружении отличном от <strong>development</strong>. Запись на диск недоступна.');
}

if (Request()->isPost() && ((!$disableZip && $action === 'download') || (!$disableHdd && $action === 'generate'))) {
    $this->setParam('part.key', Request()->get('part.key', 'record'));
    $this->setParam('part.billet', Request()->get('part.billet', 'Project\\Unknown'));
    $this->setParam('part.repository', Request()->get('part.repository', 'Project\\UnknownRepository'));

    $this->setParam('widget.template', Request()->get('widget.template', 'unknown'));
    $this->setParam('widget.path', Request()->get('widget.path', 'myWidget'));
    $this->setParam('widget.name', Request()->get('widget.name', 'example'));

    $this->setParam('fields', [
        ['view' => true, 'edit' => true, 'search' => true, 'prop' => 'field1', 'title' => 'Поле 1', 'getter' => 'field1', 'setter' => 'setField1', 'format' => 'string'],
        ['view' => true, 'edit' => true, 'search' => true, 'prop' => 'field2', 'title' => 'Поле 2', 'getter' => 'field2', 'setter' => 'setField2', 'format' => 'text'],
    ]);

    $this->setParam('generate.widget', Request()->get('generate.widget', true));

    $action  = Request()->get('action');
    $tmpDir  = '/tmp/widgetgen';
    $tmpFile = '/tmp/widgetgen.zip';

    if ($action === 'download') {
        $this->setParam('baseFolder', $tmpDir);
    }

    ob_start();

    foreach(glob(__dir('.generate/*.php')) as $file) {
        $this->include($file);
    }

    $textResult = ob_get_clean();

    if ($action === 'download') {
        $rootPath = $tmpDir;

        $zip = new ZipArchive();
        $zip->open($tmpFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $filesToDelete   = [$tmpFile];
        $foldersToDelete = [$tmpDir];

        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);

        foreach ($files as $name => $file) {
            if ($file->isDir()) {
                $foldersToDelete[] = $file->getPath();
            } elseif ($file->isFile()) {
                $filesToDelete[] = $file->getRealPath();

                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();

        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=widgetgen.zip");
        header("Content-length: " . filesize($tmpFile));

        while (ob_get_level()) {
            ob_end_clean();
        }

        readfile($tmpFile);

        // Delete all files from "delete list"
        foreach ($filesToDelete as $file) {
            unlink($file);
        }

        $foldersToDelete = array_unique($foldersToDelete);

        // Delete all empty folders
        rsort($foldersToDelete);

        foreach ($foldersToDelete as $folder) {
            rmdir($folder);
        }

        exit();
    }

    if (Request()->isAcceptJson()) {
        ReturnJson(['result' => $textResult]);
    } else {
        echo "<pre>{$textResult}</pre>";
    }

    return true;
}

Layout()->append('body.content.end', file_get_contents(__dir('.dist/view.html')));
Layout()->append('body.js.code', file_get_contents(__dir('.dist/controller.js')));

?>
<widgetgen <?=$disableZip ? 'disable-zip' : ''?> <?=$disableHdd ? 'disable-hdd' : ''?>></widgetgen>

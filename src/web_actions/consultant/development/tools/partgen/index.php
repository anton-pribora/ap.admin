<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

RequireLib('vue3');
RequireLib('toast');

Layout()->setVar('title', 'Генератор разделов');

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
    $this->setParam('part.name', Request()->get('part.name', '(Без названия)'));
    $this->setParam('part.path', Request()->get('part.path', '@consultant/unknown'));
    $this->setParam('part.table', Request()->get('part.table', 'unknown_table'));
    $this->setParam('part.menu', Request()->get('part.menu', false));
    $this->setParam('part.menuFile', Request()->get('part.menuFile', '@consultant/folder.meta.php'));
    $this->setParam('part.billet', Request()->get('part.billet', 'Project\\Unknown'));
    $this->setParam('part.repository', Request()->get('part.repository', 'Project\\UnknownRepository'));
    $this->setParam('part.recordIdKey', Request()->get('part.recordIdKey', 'record_id'));

    $this->setParam('text.afterRemove', Request()->get('text.afterRemove', 'Запись «{$record->name()}» была удалена'));
    $this->setParam('text.confirmRemove', Request()->get('text.confirmRemove', 'Вы действительно хотите удалить эту запись?'));

    $this->setParam('widget.path', Request()->get('widget.path', 'unknown'));
    $this->setParam('widget.name', Request()->get('widget.name', 'information'));

    $this->setParam('permissions.path', Request()->get('permissions.path', 'consultant.unknown'));

    $this->setParam('generate.classes', Request()->get('generate.classes', false));
    $this->setParam('generate.permissions', Request()->get('generate.permissions', false));
    $this->setParam('generate.widget', Request()->get('generate.widget', false));
    $this->setParam('generate.section', Request()->get('generate.section', false));

    $fields = Request()->get('fields', []);
    array_walk($fields, function (&$item) {
        $item += ['view' => false, 'edit' => false, 'search' => false];
    });

    $this->setParam('fields', $fields);

    $action  = Request()->get('action');
    $tmpDir  = '/tmp/partgen';
    $tmpFile = '/tmp/partgen.zip';

    if ($action === 'download') {
        $this->setParam('baseFolder', $tmpDir);
        $this->setParam('download', true);
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
        header("Content-Disposition: attachment; filename=partgen.zip");
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
<partgen <?=$disableZip ? 'disable-zip' : ''?> <?=$disableHdd ? 'disable-hdd' : ''?>></partgen>

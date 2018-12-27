<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */

$consultant = $this->argument();
$data       = $this->param('widget_data', []);
$item       = $data['item'] ?? [];
$editable   = $this->param('consultant.edit') || $this->param('consultant.information.edit');

if (!$editable) {
    header('HTTP/1.1 500 Upload file error: You can\'t change this data');
    die;
}

$key = key($_FILES);

if ($_FILES && $_FILES[$key]['error'] == 0) {
    $file = Module('site')->execute('thumbnail/update.php', [
        'parent' => $consultant,
        'path'   => $_FILES[$key]['tmp_name'],
        'name'   => $_FILES[$key]['name'],
        'mime'   => $_FILES[$key]['type'],
    ]);
    
    if ($file) {
        ReturnJson([
            'item' => $this->include('encodeItem.php')
        ]);
    } else {
        header('HTTP/1.1 500 Upload file error: Only images are allowed');
        die;
    }
} else {
    $error = $_FILES[$key]['error'] ?? 4;
    
    $phpFileUploadErrors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    );
    
    header('HTTP/1.1 500 Upload file error: '. ($phpFileUploadErrors[$error] ?? $error));
    die;
}
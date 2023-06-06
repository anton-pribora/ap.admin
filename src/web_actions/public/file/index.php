<?php

use Project\FileRepository;

$file = FileRepository::findOne(['guid' => Request()->get('guid')]);

if (!$file || !$file->id() || !is_file($file->fullPath())) {
    return Module('errors')->execute('http/404.php');
}

while (ob_get_level()) {
    ob_end_clean();
}

$filesize = filesize($file->fullPath());
$length = 0;

header('Content-type: ' . $file->mime());
header('Accept-Ranges: bytes');

$range = $_SERVER['HTTP_RANGE'] ?? false;

if ($range) {
    $partial = true;
    list($param, $range) = explode('=', $range, 2);

    if (strtolower(trim($param)) != 'bytes') {
        http_response_code(400);
        die();
    }

    $range = explode(',', $range);
    $range = explode('-', $range[0]);

    if (count($range) != 2) {
        http_response_code(400);
        die();
    }

    if ($range[0] === '') {
        $end = $filesize - 1;
        $start = $end - intval($range[0]);
    } elseif ($range[1] === '') {
        $start = intval($range[0]);
        $end = $filesize - 1;
    } else {
        $start = intval($range[0]);
        $end = intval($range[1]);

        if ($end >= $filesize || (!$start && (!$end || $end == ($filesize - 1)))) {
            $partial = false;
        }
    }

    $length = $end - $start + 1;
} else {
    $partial = false;
}

if ($partial) {
    http_response_code(206);
    header("Content-Range: bytes $start-$end/$filesize");

    $fp = fopen($file->fullPath(), 'r');

    if (!$fp) {
        http_response_code(500);
        die();
    }

    if ($start) {
        fseek($fp, $start);
    }

    while ($length) {
        $read = ($length > 8192) ? 8192 : $length;
        $length -= $read;
        print(fread($fp, $read));
    }

    fclose($fp);
} else {
    $last_modified_time = filemtime($file->fullPath());
    $etag = md5_file($file->fullPath());

    header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
    header("Etag: $etag");

    if (strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? '') == $last_modified_time
        || trim($_SERVER['HTTP_IF_NONE_MATCH'] ?? '') == $etag) {
        http_response_code(304);
        die();
    }

    header('Content-Length: ' . $filesize);

    if (Request()->get('attachment')) {
        header('Content-Disposition: attachment; filename*=UTF-8\'\''. strtr(urlencode($file->name()), ['+' => '%20']));
    } else {
        header('Content-Disposition: inline; filename*=UTF-8\'\''. strtr(urlencode($file->name()), ['+' => '%20']));
    }

    readfile($file->fullPath());
}

die();

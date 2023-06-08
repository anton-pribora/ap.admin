<?php

// Меняем владельца, если скрипт запускается под рутом
$uid = posix_geteuid();

$changeOwner = true;

if (defined('KEEP_ROOT_UID')) {
    if (KEEP_ROOT_UID === true) {
        $changeOwner = false;
    }
}

if ($uid === 0 && $changeOwner) {
    $data = posix_getpwnam('www-data');

    if ($data) {
        posix_setgid($data['gid']);
        posix_setuid(getenv('APPLICATION_ENV') === 'development' ? Config()->get('console.developer_uid', 1000) : $data['uid']);
    }
}

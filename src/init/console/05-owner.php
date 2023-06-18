<?php

// Меняем владельца, если скрипт запускается под рутом
$uid = posix_geteuid();

$changeOwner = true;

if (defined('KEEP_ROOT_UID') && KEEP_ROOT_UID === true) {
    $changeOwner = false;
}

if ($uid === 0 && $changeOwner) {
    $user = Config()->get('console.default_user');

    if (is_numeric($user)) {
        posix_setuid($user);
    } else {
        $data = posix_getpwnam($user);

        if ($data) {
            posix_setgid($data['gid']);
            posix_setuid($data['uid']);
        }
    }
}

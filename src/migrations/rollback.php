#!/usr/bin/env php
<?php

namespace migrations;

require_once __DIR__ .'/lib.inc.php';

install_db();

define('ROLLBACK', true);

$limit      = $argv[1] ?? 1;
$migrations = migrations_from_db($limit);
$files      = migrations_from_disk();

foreach ($migrations as ['name' => $migration]) {
    echo "Rollback migration ", $migration, ": ";

    if (isset($files[$migration])) {
        if (preg_match('/^ROLLBACK:/m', file_get_contents($files[$migration]))) {
            __include($files[$migration]);
            remove_migration($migration);
            echo "ok\n";
        } else {
            remove_migration($migration);
            echo "skip execute (migration doesn't support rollback)\n";
        }
    } else {
        remove_migration($migration);
        echo "no file found\n";
    }
}
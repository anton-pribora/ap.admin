#!/usr/bin/env php
<?php

namespace migrations;

require_once __DIR__ .'/lib.inc.php';

install_db();

foreach (migrations_all() as $id => $item) {
    if (empty($item['applied'])) {
        printf("Apply migration %s\n", $id);
        __include($item['file']);
        save_migration($id);
    }
}

function __include($file) {
    return include $file;
}

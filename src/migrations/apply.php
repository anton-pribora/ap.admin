<?php

namespace migrations;

require_once __DIR__ .'/lib.inc.php';

install_db();

define('APPLY', true);

foreach (migrations_all() as $id => $item) {
    if (empty($item['applied'])) {
        printf("Apply migration %s\n", $id);
        __include($item['file']);
        save_migration($id);
    }
}

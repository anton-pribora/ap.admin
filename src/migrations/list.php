<?php

namespace migrations;

require_once __DIR__ .'/lib.inc.php';

install_db();

printf("%-19s %s\n", 'Applied', 'Migration');

foreach (migrations_all() as $id => $item) {
    printf("%-19s %s\n", $item['applied'], $id);
}

#!/usr/bin/env php
<?php

namespace migrations;

require_once __DIR__ .'/lib.inc.php';

install_db();

printf("%-30s %s\n", 'Migration', 'Applied');

foreach (migrations_all() as $id => $item) {
    printf("%-30s %s\n", $id, $item['applied']);
}
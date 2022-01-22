#!/usr/bin/env php
<?php

namespace migrations;

require_once __DIR__ .'/lib.inc.php';

install_db();

foreach (remove_migrations($argv[1] ?? 1) as $migration) {
    echo "Remove migration ", $migration, "\n";
}

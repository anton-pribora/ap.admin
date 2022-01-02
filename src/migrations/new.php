#!/usr/bin/env php
<?php

namespace migrations;

require_once __DIR__ .'/lib.inc.php';

chdir(__DIR__);

$comment = join(' ', array_slice($argv, 1));
$name = new_migration($comment);

file_put_contents('dist/' . $name, <<<TEMPLATE
<?php

namespace migrations;

require_once(__DIR__ . '/../lib.inc.php');

// {$comment}
Db()->query('some sql');

TEMPLATE
);

printf("New migration %s\n", $name);

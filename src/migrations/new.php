#!/usr/bin/env php
<?php

namespace migrations;

require_once __DIR__ .'/lib.inc.php';

chdir(__DIR__);

$comment   = join(' ', array_slice($argv, 1));
$tableName = trim(preg_replace('/\W+/', '_', mb_strtolower($comment)), '_');
$name      = new_migration($comment);

file_put_contents('dist/' . $name, <<<TEMPLATE
<?php

namespace migrations;

require_once(__DIR__ . '/../lib.inc.php');

// {$comment}
Db()->query(<<<'SQL'
CREATE TABLE IF NOT EXISTS `{$tableName}` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
  -- other columns
  PRIMARY KEY (`id`)
) COMMENT '{$comment}';
SQL
);

TEMPLATE
);

printf("New migration %s\n", $name);

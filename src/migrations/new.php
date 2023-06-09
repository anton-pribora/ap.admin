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

if (defined('APPLY')) goto APPLY;
if (defined('ROLLBACK')) goto ROLLBACK;

goto END;

APPLY:

// {$comment}
Db()->query(<<<'SQL'
CREATE TABLE IF NOT EXISTS `{$tableName}` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
  -- other columns
  PRIMARY KEY (`id`)
) COMMENT '{$comment}';
SQL
);

goto END;

ROLLBACK:

// Rollback {$comment}
Db()->query(<<<'SQL'
DROP TABLE IF EXISTS `{$tableName}`;
SQL
);

goto END;

END:

TEMPLATE
);

printf("New migration %s\n", $name);

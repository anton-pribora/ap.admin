<?php

namespace migrations;

require_once(__DIR__ . '/../lib.inc.php');

if (defined('APPLY')) goto APPLY;
if (defined('ROLLBACK')) goto ROLLBACK;

goto END;

APPLY:

// profiles
Db()->query(<<<'SQL'
CREATE TABLE IF NOT EXISTS `profile` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
  `type` VARCHAR(255) NOT NULL DEFAULT 'guest' COMMENT 'Тип профиля',
  `name` VARCHAR(255) AS (CONCAT_WS(' ', JSON_UNQUOTE(JSON_EXTRACT(`meta`, '$.name.last')), JSON_UNQUOTE(JSON_EXTRACT(`meta`, '$.name.first')))) VIRTUAL,
  `meta` JSON NOT NULL DEFAULT '{}' COMMENT 'Дополнительная информация',
  `del` TINYINT NOT NULL DEFAULT 0 COMMENT 'Флаг "запись удалена"',
  -- other columns
  PRIMARY KEY (`id`)
) COMMENT 'Профили пользователей';

INSERT INTO `profile` (`id`, `type`, `meta`) VALUES (1, 'consultant', '{"name": {"first": "Администратор"},"roles":["admin","consultant"]}');
SQL
);

goto END;

ROLLBACK:

// Rollback profiles
Db()->query(<<<'SQL'
DROP TABLE IF EXISTS `consultant_profile`;
SQL
);

goto END;

END:

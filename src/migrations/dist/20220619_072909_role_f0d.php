<?php

namespace migrations;

require_once(__DIR__ . '/../lib.inc.php');

if (defined('APPLY')) goto APPLY;
if (defined('ROLLBACK')) goto ROLLBACK;

goto END;

APPLY:

// role
Db()->query(<<<'SQL'
CREATE TABLE IF NOT EXISTS `role` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
  `tag` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Коротая метка',
  `name` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'Название',
  `comment` TEXT NOT NULL DEFAULT '' COMMENT 'Описание',
  `permissions` JSON NOT NULL DEFAULT '{}' COMMENT 'Права роли',
  PRIMARY KEY (`id`)
) COMMENT 'Роли пользователей';

INSERT INTO `role` (`name`, `tag`, `comment`, `permissions`) VALUES
    ('Пользователь'         , 'consultant'        , 'Базовая роль для всех сотрудников'          , '{"consultant": true}'),
    ('Администратор'        , 'admin'             , 'Расширенный доступ к системе'               , '{"consultant": true, "consultant.role": true, "consultant.role.add": true, "consultant.role.edit": true}')
;
SQL
);

goto END;

ROLLBACK:

// Rollback role
Db()->query(<<<'SQL'
DROP TABLE IF EXISTS `role`;
SQL
);

goto END;

END:

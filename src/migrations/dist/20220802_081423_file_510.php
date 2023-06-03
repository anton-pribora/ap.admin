<?php

namespace migrations;

require_once(__DIR__ . '/../lib.inc.php');

if (defined('APPLY')) goto APPLY;
if (defined('ROLLBACK')) goto ROLLBACK;

goto END;

APPLY:

// file
Db()->query(<<<'SQL'
CREATE TABLE IF NOT EXISTS `file` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
  `parent_type` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Тип родителя',
  `parent_id` INT NOT NULL DEFAULT 0 COMMENT 'Идентификатор родителя',
  `public` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'Является ли файл публичным',
  `guid` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Уникальный идентификатор файла',
  `mime` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Тип содержимого файла',
  `name` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'Оригинальное название файла',
  `path` VARCHAR(512) NOT NULL DEFAULT '' COMMENT 'Путь к файлу',
  `size` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Размер файла в байтах',
  `meta` JSON NULL DEFAULT NULL COMMENT 'Дополнительные данные',
  `created_at` DATETIME NOT NULL DEFAULT NOW() COMMENT 'Дата и время создания записи',
  -- other columns
  PRIMARY KEY (`id`),
  INDEX `parent_id` (`parent_id`),
  INDEX `guid` (`guid`(5))
) COMMENT 'Файлы';
SQL
);

goto END;

ROLLBACK:

// Rollback file
Db()->query(<<<'SQL'
DROP TABLE IF EXISTS `file`;
SQL
);

goto END;

END:

<?php

namespace migrations;

require_once(__DIR__ . '/../lib.inc.php');

if (defined('APPLY')) goto APPLY;
if (defined('ROLLBACK')) goto ROLLBACK;

goto END;

APPLY:

// Информация о сотрудниках
Db()->query(<<<'SQL'
CREATE TABLE IF NOT EXISTS `employee` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи', 
  `name` VARCHAR(511) NOT NULL DEFAULT '' COMMENT 'ФИО', 
  `post` VARCHAR(511) NOT NULL DEFAULT '' COMMENT 'Должность', 
  `responsibilities` TEXT NOT NULL DEFAULT '' COMMENT 'Обязанности', 
  `meta` JSON NOT NULL DEFAULT '{}' COMMENT 'Дополнительные данные в формате JSON', 
  PRIMARY KEY (`id`)
) COMMENT = 'Сотрудники компании';
SQL
);

// Прикреплённые файлы
Db()->query(<<<'SQL'
CREATE TABLE IF NOT EXISTS `file` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи', 
  `guid` CHAR(16) NOT NULL DEFAULT '' COMMENT 'Уникальный идентификатор для публичного скачивания',
  `group` VARCHAR(255) NOT NULL DEFAULT 'attachment' COMMENT 'Группа, к которой относится файл (attachment, avatar, thumbnail и т.д.)', 
  `path` VARCHAR(511) NOT NULL DEFAULT '' COMMENT 'Путь на сервере', 
  `name` VARCHAR(511) NOT NULL DEFAULT '' COMMENT 'Название файла при скачивании', 
  `parent_type` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Тип родителя', 
  `parent_id` INT UNSIGNED NOT NULL COMMENT 'Идентификатор родителя', 
  `mime` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'MIME-тип содержимого файла', 
  `size` INT NOT NULL DEFAULT '0' COMMENT 'Размер файла', 
  `meta` JSON NOT NULL DEFAULT '{}' COMMENT 'Дополнительные данные в формате JSON',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время создания записи', 
  PRIMARY KEY (`id`), 
  INDEX (`parent_id`),
  INDEX (`guid`(6))
) COMMENT = 'Файлы';
SQL
);

goto END;

ROLLBACK:

// Удаляем таблицы
Db()->query(<<<'SQL'
DROP TABLE IF EXISTS `employee`;
DROP TABLE IF EXISTS `file`;
SQL
);

goto END;

END:

<?php

namespace migrations;

require_once(__DIR__ . '/../lib.inc.php');

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
CREATE TABLE `test`.`file` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи', 
  `type` VARCHAR(255) NOT NULL DEFAULT 'attachment' COMMENT 'Тип связи файла с родителем (attachment, avtar и т.д.)', 
  `path` VARCHAR(511) NOT NULL DEFAULT '' COMMENT 'Путь на сервере', 
  `name` VARCHAR(511) NOT NULL DEFAULT '' COMMENT 'Название файла при скачивании', 
  `parent_type` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Тип родителя', 
  `parent_id` INT UNSIGNED NOT NULL COMMENT 'Идентификатор родителя', 
  `mime` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'MIME-тип содержимого файла', 
  `size` INT NOT NULL DEFAULT '0' COMMENT 'Размер файла', 
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время создания записи', 
  PRIMARY KEY (`id`), 
  INDEX (`parent_id`)
) COMMENT = 'Файлы';
SQL
);

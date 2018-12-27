<?php

namespace migrations;

require_once __DIR__ .'/lib.inc.php';

// Write you code here
//
// You can use
// Db()->query('some sql');  for quering

Db()->query(<<<SQL
CREATE TABLE IF NOT EXISTS "site_item" (
  "id" int(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
  "date" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания записи',
  "type" varchar(255) NOT NULL COMMENT 'Тип записи',
  "parent_item_id" int(1) NOT NULL COMMENT 'Привязка к родителю',
  "del" tinyint(1) NOT NULL,
  PRIMARY KEY ("id")
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='Объекты сайта';    
SQL
);

Db()->query(<<<SQL
CREATE TABLE IF NOT EXISTS "site_item_meta" (
  "id" int(1) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
  "item_id" int(1) UNSIGNED NOT NULL COMMENT 'Привязка к родителю',
  "name" varchar(255) NOT NULL COMMENT 'Название меты',
  "value" mediumblob NOT NULL COMMENT 'Значение меты',
  PRIMARY KEY ("id"),
  KEY "item_id" ("item_id")
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='Данные объектов';  
SQL
);
<?php

namespace migrations;

require_once __DIR__ .'/lib.inc.php';

// Write you code here
//
// You can use
// Db()->query('some sql');  for quering

Db()->query(<<<SQL
CREATE TABLE IF NOT EXISTS "site_file" (
  "id" int(1) UNSIGNED NOT NULL COMMENT 'Идентификатор записи',
  "guid" varchar(255) NOT NULL COMMENT 'Уникальный ключ файла',
  PRIMARY KEY ("id"),
  KEY "guid" ("guid"(5))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='Реплика для файлов';
SQL
);

Db()->query(<<<SQL
CREATE TABLE IF NOT EXISTS "site_login" (
  "id" int(1) UNSIGNED NOT NULL COMMENT 'Идентификатор записи',
  "login" varchar(255) NOT NULL COMMENT 'Логин для авторизации',
  "type" varchar(255) NOT NULL COMMENT 'Тип пользователя',
  PRIMARY KEY ("id")
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COMMENT='Реплика для логинов пользователей';
SQL
);

Db()->query(<<<SQL
CREATE TABLE IF NOT EXISTS "gotcha_fields" (
  "id" int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
  "name" varchar(511) NOT NULL COMMENT 'Название поля',
  PRIMARY KEY ("id"),
  KEY "name" ("name"(5))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Поисковые поля';
SQL
);

Db()->query(<<<SQL
CREATE TABLE IF NOT EXISTS "gotcha_index" (
  "record_id" int(1) NOT NULL COMMENT 'Привязка к записи',
  "record_type_id" int(1) NOT NULL COMMENT 'Привязка к типу записи',
  "field_id" int(1) NOT NULL COMMENT 'Привязка к полю',
  "field_value" varchar(511) NOT NULL COMMENT 'Значение для поиска',
  "param1" varchar(255) NOT NULL COMMENT 'Дополнительный параметр',
  KEY "field_value" ("field_value"(5)),
  KEY "record_id" ("record_id")
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Индекс данных для поиска';
SQL
);

Db()->query(<<<SQL
CREATE TABLE IF NOT EXISTS "gotcha_options" (
  "id" int(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  "name" varchar(255) NOT NULL COMMENT 'Название опции',
  "value" varchar(511) NOT NULL COMMENT 'Значение',
  PRIMARY KEY ("id"),
  KEY "name" ("name"(5))
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Опции поисковика';
SQL
);

Db()->query(<<<SQL
CREATE TABLE IF NOT EXISTS "gotcha_types" (
  "id" int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
  "name" varchar(255) NOT NULL COMMENT 'Название типа',
  PRIMARY KEY ("id")
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Типы записей в индексе';
SQL
);

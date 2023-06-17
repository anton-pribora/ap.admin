<?php

namespace migrations;

require_once(__DIR__ . '/../lib.inc.php');

if (defined('APPLY')) goto APPLY;
if (defined('ROLLBACK')) goto ROLLBACK;

goto END;

APPLY:

// example_news
Db()->query(<<<'SQL'
CREATE TABLE IF NOT EXISTS `example_news` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
  `title` VARCHAR(511) NOT NULL DEFAULT '' COMMENT 'Заголовок',
  `text` TEXT COMMENT 'Текст',
  `date` DATE DEFAULT NOW() COMMENT 'Дата',
  `meta` JSON NOT NULL DEFAULT '{}' COMMENT 'Дополнительная информация',
  `del` TINYINT NOT NULL DEFAULT 0 COMMENT 'Флаг "запись удалена"',
  -- other columns
  PRIMARY KEY (`id`)
) COMMENT 'Тестовый справочник новостей';
SQL
);

Db()->query(<<<'SQL'
INSERT INTO `example_news` (`title`, `text`) VALUES ('Отличные новости!', 'Сегодня замечательный день, чтобы начать новый проект :)');
SQL
);

goto END;

ROLLBACK:

// Rollback example_news
Db()->query(<<<'SQL'
DROP TABLE IF EXISTS `example_news`;
SQL
);

goto END;

END:

<?php

namespace migrations;

require_once(__DIR__ . '/../lib.inc.php');

if (defined('APPLY')) goto APPLY;
if (defined('ROLLBACK')) goto ROLLBACK;

goto END;

APPLY:

// Пароль администратора
$login    = Config()->get('APPLICATION_ENV') === 'development' ? 'test' : 'admin_' . substr(sha1(random_bytes(30)), 0, 5);
$password = Config()->get('APPLICATION_ENV') === 'development' ? 'test' : sha1(random_bytes(30));
$hash     = password_hash($password, PASSWORD_DEFAULT);
$url      = FullUrl('@consultant/');

// credentials
Db()->query(<<<SQL
CREATE TABLE IF NOT EXISTS `profile_credential` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор записи',
  `profile_id` INT NOT NULL DEFAULT 0 COMMENT 'Привязка к профайлу сотрудника',
  `login` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Логин',
  `password` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Пароль',
  `created_at` DATETIME NOT NULL DEFAULT NOW() COMMENT 'Время создания',
  `last_login_time` DATETIME NULL DEFAULT NULL COMMENT 'Время последнего входа в систему',
  `del` TINYINT NOT NULL DEFAULT 0 COMMENT 'Флаг "удалён"',
  -- other columns
  PRIMARY KEY (`id`)
) COMMENT 'Данные для аутентификации';

INSERT INTO `profile_credential` (`profile_id`, `login`, `password`) VALUES (1, '{$login}', '{$hash}');
SQL
);

echo "===============================\n";
echo "Данные для входа администратора\n";
echo " Адрес: {$url}\n";
echo " Логин: {$login}\n";
echo "Пароль: {$password}\n";
echo "===============================\n";

goto END;

ROLLBACK:

// Rollback credentials
Db()->query(<<<'SQL'
DROP TABLE IF EXISTS `profile_credential`;
SQL
);

goto END;

END:

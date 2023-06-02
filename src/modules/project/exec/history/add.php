<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

$section   = $this->param('section');
$recordId  = $this->param('recordId', 0);
$profileId = $this->param('profileId', 0);;
$companyId = $this->param('companyId', 0);;
$text      = $this->param('text');
$meta      = (array) $this->param('meta');

$table = "{$section}_history";

if (!Db()->tableExists($table)) {
    $table = Db()->quoteName($table);
    $recordIdType  = 'INT';
    $recordIdIndex = '`record_id`';

    if (!is_numeric($recordId)) {
        $recordIdType   = 'VARCHAR(255)';
        $recordIdIndex .= '(5)';
    }

    $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS {$table} (
        `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Идентификатор записи',
        `date` TIMESTAMP NOT NULL DEFAULT NOW() COMMENT 'Дата записи',
        `text` TEXT NOT NULL DEFAULT '' COMMENT 'Текст сообщения',
        `record_id` {$recordIdType} NOT NULL DEFAULT 0 COMMENT 'Привязка к родительской записи',
        `profile_id` INT NOT NULL DEFAULT 0 COMMENT 'Привязка к владельцу родителькой записи',
        `company_id` INT NOT NULL DEFAULT 0 COMMENT 'Привязка к компании родителькой записи',
        `meta` JSON NULL COMMENT 'Дополнительные данные',
        INDEX `record_id` ({$recordIdIndex}),
        INDEX (`profile_id`),
        INDEX (`company_id`)
    ) COMMENT 'История изменений'
    SQL;
    Db()->query($sql);
}

$meta += [
    'req' => Request()->id(),
];

if (Identity()->getName()) {
    $text = Identity()->getName() . ': ' . $text;
}

Db()->query("INSERT {$table} (`text`, `record_id`, `profile_id`, `company_id`, `meta`) VALUES (?, ?, ?, ?, ?)", [$text, $recordId, $profileId, $companyId, json_encode_array($meta)]);

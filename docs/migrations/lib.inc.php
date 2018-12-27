<?php

namespace migrations;

require_once __DIR__ . '/../bootstrap.php';

function install_db()
{
    $sql = '
CREATE TABLE IF NOT EXISTS "_migrations" (
  "name" varchar(255) NOT NULL,
  "date" timestamp NOT NULL default CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8';
    
    Db()->query($sql);
}

function remove_db()
{
    $sql = 'DROP TABLE IF EXISTS "_migrations"';
    Db()->query($sql);
}

function save_migration($name)
{
    $sql = 'INSERT INTO "_migrations" ("name") VALUES (?)';
    Db()->query($sql, [$name]);
}

function migrations_from_db()
{
    $sql = 'SELECT * FROM "_migrations" ORDER BY "date"';
    return Db()->query($sql)->fetchAllRows();
}

function migrations_from_disk()
{
    return glob(__DIR__.'/z_*.php');
}

function migrations_all()
{
    $result = [];
    
    foreach (migrations_from_disk() as $file) {
        $key = basename($file);
        $result[$key] = [
            'applied' => null,
            'file'    => $file,
        ];
    }
    
    foreach (migrations_from_db() as $row) {
        $key = $row['name'];
        
        if (isset($result[$key])) {
            $result[$key]['applied'] = $row['date'];
        } else {
            $result[$key] = [
                'applied' => $row['date'],
                'file'    => null,
            ];
        }
    }
    
    ksort($result);
    
    return $result;
}

function new_migration()
{
    $name = [
        'z_',
        time(),
        '_',
        substr(sha1(uniqid()), 0, 3),
        '.php',
    ];
    
    return join($name);
}
<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Database\Pdo;

use ApCode\Database\DatabaseInterface;
use PDO;

class MySql implements DatabaseInterface
{
    private $dsn;
    private $login;
    private $password;
    private $options;

    private $ansiQuotes = false;

    /**
     * @var PDO
     */
    private $pdo;

    private $totalQueries = 0;
    private $totalTime = 0;

    public function __construct($dsn, $login, $password, array $options = [])
    {
        $this->dsn      = $dsn;
        $this->login    = $login;
        $this->password = $password;

        $this->options = $options + [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
    }

    private function connect()
    {
        $this->pdo = new PDO($this->dsn, $this->login, $this->password, $this->options);
    }

    public function disconnect()
    {
        $this->pdo = null;
    }

    public function setAnsiQuotes(bool $value)
    {
        $this->ansiQuotes = $value;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\DatabaseInterface::query()
     */
    public function query($sql, $params = array())
    {
        if (empty($this->pdo)) {
            $this->connect();
        }

        $startTime = microtime(true);

        if ( $params ) {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($params);
        }
        else {
            $statement = $this->pdo->query($sql);
        }

        $elapsed = microtime(true) - $startTime;

        $this->totalQueries += 1;
        $this->totalTime += $elapsed;

        return new QueryResult($statement, $elapsed);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\DatabaseInterface::quote()
     */
    public function quote($data)
    {
        if (empty($this->pdo)) {
            $this->connect();
        }

        return $this->pdo->quote($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function quoteArray($data)
    {
        return array_map([$this, 'quote'], (array) $data);
    }

    private function quoteNameAnsi($data)
    {
        return '"' . strtr($data, ['"' => '""', '.' => '"."']) . '"';
    }

    private function quoteNameMySQL($data)
    {
        return '`' . strtr($data, ['`' => '\\`', '.' => '`.`']) . '`';
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\DatabaseInterface::quoteName()
     */
    public function quoteName($data)
    {
        return $this->ansiQuotes ? $this->quoteNameAnsi($data) : $this->quoteNameMySQL($data);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\DatabaseInterface::lastInsertId()
     */
    public function lastInsertId()
    {
        if (empty($this->pdo)) {
            $this->connect();
        }

        return $this->pdo->lastInsertId();
    }

    public function totalQueries()
    {
        return $this->totalQueries;
    }

    public function totalTime()
    {
        return $this->totalTime;
    }

    public function tableExists($tableName)
    {
        if (strpos($tableName, '.')) {
            [$db, $tableName] = explode('.', $tableName, 2);
            $sql = 'SHOW TABLES FROM ' . $this->quoteName($db) . ' LIKE ' . $this->quote($tableName);
        } else {
            $sql = 'SHOW TABLES LIKE ' . $this->quote($tableName);
        }

        $res = $this->query($sql);
        $aff = $res->affected();
        $res->free();

        return boolval($aff);
    }
}

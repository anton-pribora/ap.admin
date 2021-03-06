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
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode="ANSI"',
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
     * {@inheritDoc}
     * @see \ApCode\Database\DatabaseInterface::quoteName()
     */
    public function quoteName($data)
    {
        return '"'. strtr($data, ['"' =>'""', '.' => '"."']) .'"';
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
}
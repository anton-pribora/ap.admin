<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Database\Pdo;

use ApCode\Database\QueryResultInterface;
use PDO;

class QueryResult implements QueryResultInterface
{
    private $elapsed;
    private $stm;
    
    public function __construct(\PDOStatement $stm, $elapsed)
    {
        $this->elapsed = $elapsed;
        $this->stm = $stm;
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Database\QueryResultInterface::elapsedTime()
     */
    public function elapsedTime()
    {
        return $this->elapsed;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\QueryResultInterface::affected()
     */
    public function affected()
    {
        return $this->stm->rowCount();
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\QueryResultInterface::fetchValue()
     */
    public function fetchValue()
    {
        return $this->stm->fetchColumn();
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\QueryResultInterface::fetchColumn()
     */
    public function fetchColumn()
    {
        return $this->stm->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\QueryResultInterface::fetchRow()
     */
    public function fetchRow()
    {
        return $this->stm->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\QueryResultInterface::fetchRows()
     */
    public function fetchAllRows()
    {
        return $this->stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\QueryResultInterface::fetchObject()
     */
    public function fetchObject($class = NULL, $constructorArguments = NULL)
    {
        if (isset($class)) {
            return $this->stm->fetchObject($class, (array) $constructorArguments);
        }
        
        return $this->stm->fetch(PDO::FETCH_OBJ);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\QueryResultInterface::fetchObjects()
     */
    public function fetchAllObjects($class = NULL, $constructorArguments = NULL)
    {
        if (isset($class)) {
            return $this->stm->fetchAll(PDO::FETCH_CLASS, $class, (array) $constructorArguments);
        }
        
        return $this->stm->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\QueryResultInterface::columns()
     */
    public function columns()
    {
        $result = [];
        
        for ($i = 0; $i < $this->stm->columnCount(); ++$i) {
            $result[] = $this->stm->getColumnMeta($i);
        }
        
        return $result;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Database\QueryResultInterface::free()
     */
    public function free()
    {
        $this->stm->closeCursor();
    }
}
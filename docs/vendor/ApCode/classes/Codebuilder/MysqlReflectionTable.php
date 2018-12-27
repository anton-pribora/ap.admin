<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

use ApCode\Database\DatabaseInterface;

class MysqlReflectionTable
{
    protected $schemata = null;
    protected $table    = null;
    protected $db       = null;
    
    protected $columns = [];
    protected $comment  = null;
    
    public function __construct(DatabaseInterface $db, $table, $schemata = null)
    {
        $this->db       = $db;
        $this->table    = $table;
        $this->schemata = $schemata ?: $this->db->query('SELECT DATABASE()')->fetchValue();
        
        $this->describe();
    }
    
    protected function describe()
    {
        $sql = 'SELECT `TABLE_COMMENT` FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA` = ? AND `TABLE_NAME` = ?';
        $row = $this->db->query($sql, [$this->schemata, $this->table])->fetchRow();
        
        $this->comment = $row['TABLE_COMMENT'];
        $sql = 'SELECT `COLUMN_NAME`, `DATA_TYPE`, `COLUMN_TYPE`, `COLUMN_COMMENT` FROM `information_schema`.`COLUMNS` WHERE `TABLE_SCHEMA` = ? AND `TABLE_NAME` = ? ORDER BY `ORDINAL_POSITION`';
        $res = $this->db->query($sql, [$this->schemata, $this->table]);
        
        foreach ( $res->fetchAllRows() as $row )
        {
            $column = new MysqlReflectionColumn($this);
            
            $column->setName($row['COLUMN_NAME']);
            $column->setDataType($row['DATA_TYPE']);
            $column->setType($row['COLUMN_TYPE']);
            $column->setComment($row['COLUMN_COMMENT']);
            
            $this->columns[] = $column;
        }
    }
    
    public function hasColumns()
    {
        return count($this->columns) > 0;
    }
    
    /**
     * 
     * @return MysqlReflectionColumn[]
     */
    public function getColumns()
    {
        return $this->columns;
    }
    
    public function hasComment()
    {
        return strlen($this->comment) > 0;
    }
    
    public function getComment()
    {
        return $this->comment;
    }
    
    public function getName()
    {
        return $this->table;
    }
    
    public function getSchemata()
    {
        return $this->schemata;
    }
}
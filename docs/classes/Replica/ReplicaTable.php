<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Replica;

use ApCode\Database\DatabaseInterface;

class ReplicaTable
{
    private $table;
    private $idfield;
    private $fields;
    
    public function __construct($table, $idfield, $fields)
    {
        $this->table = $table;
        $this->idfield = $idfield;
        $this->fields = $fields;
    }
    
    public function apply(DatabaseInterface $db)
    {
        $table = $db->quoteName($this->table);
        $idfield = $db->quoteName($this->idfield);
        
        $id = $this->fields[$this->idfield] ?? null;
        
        if (empty($id)) {
            throw new \Exception('Invalid replica data. Id is required.');
        }
        
        $sql = "SELECT $idfield FROM $table WHERE $idfield = ?";
        $res = Db()->query($sql, [$id]);
        
        if ($res->affected()) {
            $fields = [];
            
            foreach ($this->fields as $name => $value) {
                if ($name != $this->idfield) {
                    $fields[] = $db->quoteName($name) .' = '. $db->quote($value);
                }
            }
            
            $fields = join(', ', $fields);
            
            $sql = "UPDATE $table SET $fields WHERE $idfield = ?";
            Db()->query($sql, [$id]);
        } else {
            $fields = [];
            $values = [];
            
            foreach ($this->fields as $name => $value) {
                $fields[] = $db->quoteName($name);
                $values[] = $db->quote($value);
            }
            
            $fields = join(', ', $fields);
            $values = join(', ', $values);
            
            $sql = "INSERT $table ($fields) VALUES ($values)";
            
            Db()->query($sql);
        }
    }
    
    public function delete(DatabaseInterface $db)
    {
        $table = $db->quoteName($this->table);
        $idfield = $db->quoteName($this->idfield);
        
        $id = $this->fields[$this->idfield] ?? null;
        
        if (empty($id)) {
            throw new \Exception('Invalid replica data. Id is required.');
        }
        
        $sql = "DELETE FROM $table WHERE $idfield = ?";
        $res = Db()->query($sql, [$id]);
    }
}
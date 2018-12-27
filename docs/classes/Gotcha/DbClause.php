<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Gotcha;

class DbClause
{
    private $value;
    private $compare;
    private $logic;
    
    private $dbField;
    private $moreFields;
    
    public function __construct($dbField, $value, $compare = NULL, $logic = NULL)
    {
        $this->dbField = $dbField;
        $this->value   = $value;
        $this->compare = $compare ?? '%%';
        $this->logic   = $logic   ?? 'OR';
        
        if ($this->logic != 'OR' and $this->logic != 'AND') {
            throw new \Exception('The logic must be one of OR or AND');
        }
    }
    
    public function addMoreField(DbClause $field)
    {
        $this->moreFields[] = $field;
        return $this;
    }
    
    public function getSqlCondition()
    {
        $result = [];
        
        switch ($this->compare) {
            case '=':
            case 'eq':
                $result[] = $this->getSqlEqual();
                break;

            case '<>':
            case '!=':
                $result[] = $this->getSqlNotEqual();
                break;
                
            case '><':
            case 'between':
                $result[] = $this->getSqlBetween();
                break;
                
            case '>':
            case '<':
            case '<=':
            case '>=':
                $result[] = $this->getSqlCompare($this->compare);
                break;
                
            case '%%':
            case 'any':
                $result[] = $this->getSqlAny();
                break;
                
            default:
                throw new \Exception(sprintf('Unknown compare type `%s\'', $this->compare));
                break;
        }
        
        if ($this->moreFields) {
            $result = array_merge($result, $this->moreFields);
        }
        
        return join(' AND ', $result);
    }
    
    public function __toString()
    {
        return $this->getSqlCondition();
    }
    
    private function quote($value)
    {
        return Db()->quote($value);
    }
    
    private function quotedColumn()
    {
        return Db()->quoteName($this->dbField);
    }
    
    private function getSqlCompare($type)
    {
        return $this->quotedColumn() .' '. $type .' '. floatval($this->value);
    }
    
    private function quoteArray(&$array)
    {
        foreach ($array as &$value) {
            $value = $this->quote($value);
        }
    }
    
    private function getSqlEqual()
    {
        if (is_array($this->value)) {
            if ($this->value) {
                $arr = [];
                
                foreach ($this->value as $search) {
                    $arr[] = $this->quotedColumn() .' LIKE '. $this->quote("$search");
                }
                
                return '('. join(' '. $this->logic .' ', $arr) .')';
            } else {
                $this->value = '';
            }
        }
        
        return $this->quotedColumn() .' LIKE '. $this->quote("$this->value");
    }
    
    private function getSqlBetween()
    {
        $from = $this->value[0] ?? $this->value['from'];
        $to   = $this->value[1] ?? $this->value['to'];
        
        return $this->quotedColumn() .' BETWEEN '. floatval($from) .' AND '. floatval($to);
    }
    
    private function getSqlNotEqual()
    {
        if (is_array($this->value)) {
            if ($this->value) {
                $arr = [];
                
                foreach ($this->value as $search) {
                    $arr[] = $this->quotedColumn() .' NOT LIKE '. $this->quote("$search");
                }
                
                return '('. join(' AND ', $arr) .')';
            } else {
                $this->value = '';
            }
        }
        
        return $this->quotedColumn() .' NOT LIKE '. $this->quote("$this->value");
    }
    
    private function getSqlAny()
    {
        if (is_array($this->value)) {
            if ($this->value) {
                $arr = [];
                
                foreach ($this->value as $search) {
                    $arr[] = $this->quotedColumn() .' LIKE '. $this->quote("%$search%");
                }
                
                return '('. join(' '. $this->logic .' ', $arr) .')';
            } else {
                return $this->quotedColumn() .' LIKE \'\'';
            }
        }
        
        $search = $this->value !== '' ? $this->quote("%$this->value%") : "''";
        return $this->quotedColumn() .' LIKE ' . $search;
    }
}
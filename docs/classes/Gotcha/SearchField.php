<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Gotcha;

class SearchField
{
    private $field;
    private $clause;
    
    public function __construct($field, $value, $compare = NULL, $logic = NULL)
    {
        $this->field  = $field;
        $this->clause = new DbClause('field_value', $value, $compare, $logic);
    }
    
    public function addParam($value, $compare = NULL, $logic = NULL, $dbField = 'param1')
    {
        $param = new DbClause($dbField, $value, $compare, $logic);
        $this->clause->addMoreField($param);
        
        return $param;
    }
    
    public function field()
    {
        return $this->field;
    }
    
    public function getSqlCondition()
    {
        return $this->clause->getSqlCondition();
    }
    
    public function __toString()
    {
        return $this->getSqlCondition();
    }
}
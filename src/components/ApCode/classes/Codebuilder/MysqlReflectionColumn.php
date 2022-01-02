<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class MysqlReflectionColumn
{
    protected $name = null;

    protected $dataType = null;

    protected $type = null;

    protected $comment = null;

    protected $table = null;
    
    public function __construct(MysqlReflectionTable $table)
    {
        $this->table = $table;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getDataType()
    {
        return $this->dataType;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}
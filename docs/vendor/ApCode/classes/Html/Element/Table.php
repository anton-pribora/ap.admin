<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Table extends ContentableElement
{
    protected $tagName = 'table';

    protected $thead = null;
    
    protected $tbody = null;
    
    protected $tfoot = null;
    
    public function createBodyTdRow(...$values)
    {
        $tr = $this->createTr();
        
        foreach ( $values as $value ) {
            $tr->createTd($value);
        }
        
        return $tr;
    }
    
    public function createHeadThRow(...$values)
    {
        $tr = $this->thead()->createTr();
        
        foreach ( $values as $value ) {
            $tr->createTh($value);
        }
        
        return $tr;
    }
    
    public function createBodyThTdRow($th, ...$td)
    {
        $tr = $this->createTr();
        
        $tr->createTh($th);
        
        foreach ( $td as $value ) {
            $tr->createTd($value);
        }
        
        return $tr;
    }
    
    public function thead()
    {
        if ( !isset($this->thead) )
        {
            $this->thead = new Thead();
            $this->addSubElement($this->thead);
        }
        
        return $this->thead;
    }
    
    public function tbody()
    {
        if ( !isset($this->tbody) )
        {
            $this->tbody = new Tbody();
            $this->addSubElement($this->tbody);
        }
        
        return $this->tbody;
    }
    
    public function tfoot()
    {
        if ( !isset($this->tfoot) )
        {
            $this->tfoot = new Tfoot();
            $this->addSubElement($this->tfoot);
        }
        
        return $this->tfoot;
    }
    
    public function createTr()
    {
        return $this->tbody()->createTr();
    }
    
    /**
     * Set Enables a sorting interface for the table
     * 
     * @param $value
     */
    function setSortable($value)
    {
        $this->setAttribute("sortable", $value);
        return $this;
    }

    /**
     * Get Enables a sorting interface for the table
     */
    function getSortable()
    {
        return $this->getAttribute("sortable");
    }
}

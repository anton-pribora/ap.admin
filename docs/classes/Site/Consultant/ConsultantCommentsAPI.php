<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site\Consultant;

use Site\Item;

class ConsultantCommentsAPI
{
    private $storage;
    private $parent;
    
    public function __construct(Item $parent)
    {
        $this->parent  = $parent;
        $this->storage = &$parent->meta()->getLink("{$parent->type()}.comments", []);
    }
    
    public function saveConsultantComments()
    {
        $this->parent->meta()->save($this->parent->type());
    }
    
    public function addNewConsultantComment()
    {
        $data = [];
        array_unshift($this->storage, '');
        $this->storage[0] = &$data;
        
        $comment = new ConsultantComment($data);
        $comment->setDate('now');
        $comment->setId($this->nextId());
        
        return $comment;
    }
    
    private function nextId()
    {
        $maxId = 0;
        
        foreach ($this->consultantComments() as $item) {
            $maxId = max($item->id(), $maxId);
        }
        
        return $maxId + 1;
    }
    
    public function findConsultantCommentById($value)
    {
        foreach ($this->consultantComments() as $item) {
            if ($item->id() == $value) {
                return $item;
            }
        }
        
        return null;
    }
    
    public function removeConsultantComment(ConsultantComment $item)
    {
        $i = 0;
        
        foreach ($this->storage as $row) {
            if (($row['id'] ?? -1) == $item->id()) {
                array_splice($this->storage, $i, 1);
                break;
            }
            
            ++$i;
        }
        
        return $this;
    }
    
    public function consultantComments()
    {
        $list = [];
        
        foreach ($this->storage as &$row) {
            $list[] = new ConsultantComment($row);
        }
        
        return $list;
    }
}
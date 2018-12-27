<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Site;

use Data\DefaultThumbnail;

/**
 * Объекты сайта
 */
class Item extends \ApCode\Billet\AbstractBillet
{
    private $meta;
    protected $type;
    
    protected function beforeSave()
    {
        parent::beforeSave();
        $this->setType($this->type);
    }
    
    public function id()
    {
        return $this->data['id'] ?? null;
    }

    protected function setId($value)
    {
        $this->data['id'] = $value;
        return $this;
    }

    public function date()
    {
        return $this->data['date'] ?? null;
    }

    protected function setDate($value)
    {
        $this->data['date'] = $value;
        return $this;
    }

    public function type()
    {
        return $this->data['type'] ?? $this->type ?? null;
    }

    protected function setType($value)
    {
        $this->data['type'] = $value;
        return $this;
    }

    public function parentItemId()
    {
        return $this->data['parentItemId'] ?? null;
    }

    protected function setParentItemId($value)
    {
        $this->data['parentItemId'] = $value;
        return $this;
    }

    public function del()
    {
        return $this->data['del'] ?? null;
    }
    
    public function isDeleted()
    {
        return $this->del() > 0;
    }

    public function setDel($value)
    {
        $this->data['del'] = $value;
        return $this;
    }
    
    
    // --- thumbnails api
    public function thumbnail($size)
    {
        return $this->thumbnailAPI()->getThumbnail($size) ?? new DefaultThumbnail($size);
    }
    
    public function thumbnailId()
    {
        return $this->thumbnailAPI()->thumbnailId();
    }
    
    public function setThumbnailId($id)
    {
        $this->thumbnailAPI()->setThumbnailId($id);
        return $this;
    }
    
    protected function thumbnailAPI()
    {
        return new ThumbnailAPI($this->meta()->getLink("{$this->type}.thumbnail"));
    }
    // --- end of thumbnails api
    
    
    /**
     * @return \Site\Item\MetaAPI
     */
    public function meta()
    {
        if (empty($this->meta)) {
            $this->meta = new Item\MetaAPI($this);
        }
        
        return $this->meta;
    }
}
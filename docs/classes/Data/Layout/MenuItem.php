<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace Data\Layout;

class MenuItem
{
    public $priority = 0;
    public $href     = NULL;
    public $text     = NULL;
    public $active   = NULL;
    
    /**
     * @var \Data\Layout\Menu
     */
    private $subMenu = NULL;
    
    public function __construct(array $props)
    {
        foreach ($props as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
    
    public function hasSubMenu()
    {
        return $this->subMenu && count($this->subMenu->items());
    }
    
    /**
     * @return \Data\Layout\Menu
     */
    public function subMenu()
    {
        if (empty($this->subMenu)) {
            $this->subMenu = new Menu();
        }
        
        return $this->subMenu;
    }
    
    public function hasActiveItems()
    {
        return $this->subMenu && $this->subMenu->hasActiveItems();
    }
}
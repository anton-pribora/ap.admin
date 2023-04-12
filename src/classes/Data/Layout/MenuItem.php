<?php

namespace Data\Layout;

class MenuItem
{
    public $priority    = 0;
    public $href        = null;
    public $text        = null;
    public $active      = null;
    public $isSeparator = null;
    public $icon        = null;
    public $visible     = null;

    /**
     * @var \Data\Layout\Menu
     */
    private $subMenu = null;

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
        return $this->active || ($this->subMenu && $this->subMenu->hasActiveItems());
    }
}

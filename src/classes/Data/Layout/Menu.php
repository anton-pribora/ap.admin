<?php

namespace Data\Layout;

class Menu
{
    /**
     * @var \Data\Layout\MenuItem
     */
    private $items  = [];
    private $sorted = FALSE;

    /**
     * @return \Data\Layout\MenuItem[]
     */
    public function items()
    {
        if (!$this->sorted) {
            $this->sort();
        }

        return $this->items;
    }

    /**
     * @return \Data\Layout\MenuItem
     */
    public function createItem($props, $active = FALSE, $priority = 0)
    {
        $item = new MenuItem($props, $active, $priority);
        $this->items[] = $item;
        $this->sorted  = false;

        return $item;
    }

    public function hasActiveItems()
    {
        foreach ($this->items as $item) {
            if ($item->active || $item->hasActiveItems()) {
                return true;
            }
        }

        return false;
    }

    private function sort()
    {
        usort($this->items, function(MenuItem $item1, MenuItem $item2){
            return $item1->priority - $item2->priority;
        });

        $this->sorted = true;
    }
}

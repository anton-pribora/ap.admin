<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Misc;

trait Triggers
{
    private $triggers = [];
    
    public function appendTrigger($category, callable $function)
    {
        if ( !isset($this->triggers[ $category ]) ) {
            $this->triggers[ $category ] = [];
        }
        
        $this->triggers[ $category ][] = $function;
        
        return $this;
    }
    
    private function launchTriggers($category, ...$args)
    {
        if ( isset($this->triggers[ $category ]) ) {
            foreach ( $this->triggers[ $category ] as $function ) {
                $function(...$args);
            }
        }
    }
}
<?php

use ApCode\Template\Layout\Renderer\Callback;
use ApCode\Html\Element\Li;

$callback = new Callback(
    function ($value, $active){
        if ($value == false) {
            $li = new Li();
            $li->setClass('divider');
        } else {
            $li = new Li($value);
        }
        
        return $li;
    }, 
    function ($values){
        return join($values);
    }
);

Layout()->setRendererIfEmpty('usermenu', $callback);
<?php

use ApCode\Template\Layout\Renderer\Callback;
use ApCode\Html\Element\Li;
use ApCode\Html\Element\A;
use ApCode\Html\Element\AbstractElement;

$renderer = new Callback(
    function ($value, $active) {
        $li = new Li($value);
        $li->addClass('nav-item');
        
        if ($active) {
            $li->addClass('active');
        }
        
        if ($value instanceof A) {
            $value->addClass('nav-link');
        }
        
        if ($value instanceof AbstractElement && $active) {
            $value->addClass('active');
        }
        
        return $li;
    },
    function ($values) {
        return join($values);
    }
);

Layout()->setRendererIfEmpty('topMenu', $renderer);
Layout()->setRendererIfEmpty('topLeftMenu', $renderer);
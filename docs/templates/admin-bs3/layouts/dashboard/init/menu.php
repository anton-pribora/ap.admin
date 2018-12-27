<?php

use ApCode\Template\Layout\Renderer\Callback;

use ApCode\Html\Element;
use ApCode\Html\Element\AbstractElement;
use ApCode\Html\Element\Ol;

Layout()->setRendererIfEmpty('menu', new Callback(
    function ($value, $active) {
        $li = new Element\Li($value);
        
        if ($value instanceof AbstractElement && $active) {
            $value->addClass('active');
        }
        
        return $li;
    },
    function ($values) {
        return join($values);
    }
));

$callback = new Callback(
    function ($value, $active){
        $li = new Element\Li($value);
        
        if ($active) {
            $li->setClass('active');
        }
        
        return $li;
    }, 
    function ($values){
        return join($values);
    }
);

Layout()->setRendererIfEmpty('layouts', $callback);


$callback = new Callback(
    function ($value, $active){
        $li = new Element\Li($value);
        return $li;
    },
    function ($values){
        $ol = new Ol();
        $ol->setClass('breadcrumb');

        foreach ($values as $li) {
            $ol->addSubElement($li);
        }

        return $ol;
    }
    );

Layout()->setRendererIfEmpty('breadcrumbs', $callback);
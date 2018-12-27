<?php

use ApCode\Html\Element\Ul;

/* @var $this ApCode\Template\Template */

$nav  = $this->argument(0);

$ul = new Ul();
$ul->setClass('nav nav-pills');

$ul->addStyle('margin-bottom: 20px;');

foreach ($nav as $item) {
    $li = $ul->createLi();
    
    if (!empty($item['href'])) {
        $a = $li->createA($item['title'], $item['href']);
    } else {
        $li->addContents($item['title']);
    }
    
    if (!empty($item['active'])) {
        $li->setClass('active');
    }
}

echo $ul;
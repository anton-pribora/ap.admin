<?php

use ApCode\Html\Element\Ul;

/* @var $this ApCode\Template\Template */

$nav  = $this->argument(0);

$ul = new Ul();
$ul->setClass('nav nav-pills');

$ul->addStyle('margin-bottom: 20px;');

foreach ($nav as $item) {
    $li = $ul->createLi();
    $li->addClass('nav-item');

    if (!empty($item['href'])) {
        $a = $li->createA($item['title'], $item['href']);
        $a->addClass('nav-link');
    } else {
        $li->addContents($item['title']);
    }

    if (!empty($item['active'])) {
        $a->addClass('active');
    }
}

echo $ul;

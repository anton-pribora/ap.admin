<?php

use ApCode\Html\Element\Ul;

/* @var $this ApCode\Template\Template */
/* @var $pagination Pagination */
$pagination = $this->argument(0);

if ($pagination->totalPages() <= 0) {
    return true;
}

$ul = new Ul();
$ul->setClass('pagination');

if ($this->hasParam('style')) {
    $ul->setAttribute('style', $this->param('style'));
}

// First button
$li = $ul->createSubElement('li');
        
if ( $pagination->page() <= 0 ) {
    $li->createA('«');
    $li->setClass('disabled');
}
else {
    $li->createA('«', $pagination->pageUrl($pagination->page() - 1));
}

$leftOffsetStart  = 1;
$leftOffsetEnd    = $pagination->page() - 5;
$rightOffsetStart = $pagination->page() + 5;
$rightOffsetEnd   = $pagination->totalPages() - 1;

if ( $leftOffsetEnd - $leftOffsetStart <= 2 ) {
    $leftOffsetEnd = $leftOffsetStart;
}

if ( $rightOffsetEnd - $rightOffsetStart <= 2 ) {
    $rightOffsetEnd = $rightOffsetStart;
}

$showedLeftDots  = false;
$showedRightDots = false;

for($page = 0; $page < $pagination->totalPages(); ++$page) {
    if ( $page >= $leftOffsetStart && $page < $leftOffsetEnd ) {
        if ( !$showedLeftDots ) {
            $showedLeftDots = true;
            
            $li = $ul->createLi();
            $li->createA('...');
            $li->setClass('disabled');
        }
        
        continue;
    }
    
    if ( $page > $rightOffsetStart && $page < $rightOffsetEnd ) {
        if ( !$showedRightDots ) {
            $showedRightDots = true;
            
            $li = $ul->createLi();
            $li->createA('...');
            $li->setClass('disabled');
        }
        
        continue;
    }
    
    $li = $ul->createLi();
    $li->createA($page + 1, $pagination->pageUrl($page));
    
    if ( $page == $pagination->page() ) {
        $li->setClass('active');
    }
}

// Last button
$li = $ul->createLi();

if ( $pagination->page() == $pagination->totalPages() - 1 ) {
    $li->createA('»');
    $li->setClass('disabled');
}
else {
    $li->createA('»', $pagination->pageUrl($pagination->page() + 1));
}


echo $ul;

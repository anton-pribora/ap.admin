<?php

use ApCode\Html\Element\Pre;
use ApCode\Html\Element\UnescapedText;

/* @var $this ApCode\Template\Template */

$code  = $this->argument(0);
$class = $this->argument(1);

$pre = new Pre();
$pre->addSubElement(new UnescapedText(trim(highlight_string($code, true))));
$pre->addStyle('background-color: white');

echo $pre;
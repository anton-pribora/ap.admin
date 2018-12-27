<?php

/* @var $this ApCode\Executor\RuntimeInterface */
/* @var $consultant Site\Consultant */

$consultant = $this->argument();

ReturnJson(['item' => $this->include('encodeItem.php')]);
<?php

/* @var $this ApCode\Executor\RuntimeInterface */

if (!$this->scopeVar('init')) {
    $this->include('../dist/view_dialog.php');
    $this->setScopeVar('init', true);
}

<?php

/* @var $this ApCode\Executor\RuntimeInterface */

if (!$this->scopeVar('init')) {
    RequireLib('plankton');
    $this->include('../dist/view_dialog.php');
    
    $this->setScopeVar('init', true);
}
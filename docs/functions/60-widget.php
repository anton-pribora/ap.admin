<?php

use Data\ComplexResult;

function Widget($command, ...$args) {
    static $widgets = [];
    
    list($widget, $action) = explode('::', $command, 2) + ['default', 'view'];
    
    if (!isset($widgets[$widget])) {
        $path = strtr($widget, '.', '/');
        $config = ExpandPath("@widgets/$path/widget.php");
        
        if (file_exists($config)) {
            $widgets[$widget] = include $config;
        } else {
            return "Widget $widget not found";
        }
    }
    
    $module  = $widgets[$widget];
    $action .= '.php';
    
    $result = new ComplexResult();
    
    if (!$module->canExecute($action)) {
        return $result
            ->setResult(false)
            ->setOutput("Widget action $command not found")
        ;
    }
    
    ob_start();
    
    return $result
        ->setResult($module->execute($action, ...$args))
        ->setOutput(ob_get_clean())
    ;
}
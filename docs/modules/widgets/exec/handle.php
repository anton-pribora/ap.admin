<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

if (Request()->isPost() && Request()->has('widget_action')) {
    $widgetAction = Request()->get('widget_action');
    $widgetData   = Request()->get('widget_data', []);
    
    $args  = $this->argumentList();
    $count = count($args);
    
    if ($count && is_array($args[$count - 1])) {
        $args[$count - 1]['widget_data'] = $widgetData;
    } else {
        $args[] = ['widget_data' => $widgetData,];
    }
    
    $logData = $widgetData;
    
    array_walk_recursive($logData, function (&$item){
        $item = mb_strimwidth($item, 0, 40, '…');
    });
    
    Logger()->log('widget', $widgetAction .'('. json_encode($logData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).')');
    
    echo Widget($widgetAction, ...$args);
    
    header('HTTP/1.1 500 Invalid widget action');
    die();
}

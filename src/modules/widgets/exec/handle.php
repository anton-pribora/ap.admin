<?php

/**
 * @var ApCode\Executor\RuntimeInterface $this
 */

if (Request()->isPost()) {
    if (Request()->isJson()) {
        $json = Request()->readJson();

        if (json_last_error()) {
            header('HTTP/1.1 400 ' . json_last_error_msg());
            die();
        }
    } elseif (Request()->has('widget_action')) {
        $json = Request()->getPostVariables();
    } else {
        return true;
    }

    $widgetAction = $json['widget_action'] ?? '';
    $widgetData   = $json['widget_data'] ?? [];

    $args  = $this->argumentList();
    $count = count($args);

    if ($count && is_array($args[$count - 1])) {
        $args[$count - 1]['widget_data'] = $widgetData;
    } else {
        $args[] = ['widget_data' => $widgetData,];
    }

    $logData = $widgetData;

    array_walk_recursive($logData, function (&$item){
        $item = mb_strimwidth((string) $item, 0, 40, '…');
    });

    Logger()->log('widget', $widgetAction .'('. json_encode($logData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES).')');

    // Каждый виджет должен сам решать, в каком формате и какие данные возвращать
    echo Widget($widgetAction, ...$args);

    // Если виджет не отдал данные клиенту, возвращаем ошибку
    ReturnJsonError('Invalid widget action ' . $widgetAction, 'invalid_action');
}

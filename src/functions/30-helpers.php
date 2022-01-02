<?php 

function Redirect($url) {
    header('Location: '. $url);

    while (ob_get_level()) {
        ob_end_clean();
    }

    die;
}

function Refresh() {
    Redirect(Request()->uri());
}

function AddSessionAlert($text, $type = 'info') {
    Session()->append('alerts', [$text, $type]);
}

function PopAlerts() {
    return Session()->pop('alerts', []);
}

function ReturnJson($data = NULL) {
    while (ob_get_level()) {
        ob_end_clean();
    }

    header('Content-type: application/json');
    die(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
}

function ReturnJsonError($description, $code = 'unknown', $data = NULL) {
    ReturnJson([
        'error' => [
            'code'        => $code,
            'description' => $description,
            'data'        => $data,
        ]
    ]);
}

function Hostconfig($name) {
    return Config()->get("host.$name");
}

function ExpandPath($alias) {
    return PathAlias()->expand($alias);
}

function ExpandUrl($alias) {
    return UrlAlias()->expand($alias);
}

function Alert($message, $class = NULL) {
    return Template()->render('@extra/alert.php', $message, ['class' => $class]);
}
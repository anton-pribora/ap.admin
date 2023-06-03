<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

return static function ($contacts) {
    $result = [];
    static $icons = null;

    if (is_null($icons)) {
        $icons = Module('misc')->execute('lib/project/contacts/icons.php');
    }

    foreach ($contacts as ['type' => $type, 'value' => $value]) {
        $value = ($icons[$type] ?? $icons['default']) . ' ' . $value;
        $result[] = $value;
    }

    return join(', ', $result);
};

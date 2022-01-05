<?php

use ApCode\Executor\PhpFileExecutor;

return new class (ROOT_DIR . '/permissions') extends PhpFileExecutor {
    protected function prepareAction($action)
    {
        $action = strtr(trim($action, '/'), ['.php' => '']);
        return strtr($action, ['.' => '/']) . '.php';
    }
};

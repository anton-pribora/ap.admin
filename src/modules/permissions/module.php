<?php

use ApCode\Executor\PhpFileExecutor;

return new class (ExpandPath('@permissions')) extends PhpFileExecutor {
    private $sourceAction;

    protected function prepareAction($action)
    {
        $this->sourceAction = $action;

        if (substr($action, 0, 1) === '/') {
            return $action;
        }

        $action = strtr($action, ['.php' => '']);
        return strtr($action, ['.' => '/']) . '.php';
    }

    protected function actionExists()
    {
        return true;
    }

    protected function doAction()
    {
        if (file_exists($this->getActionFile())) {
            return parent::doAction();
        }

        trigger_error("Permit '{$this->sourceAction}' doesn't exist", E_USER_WARNING);

        return false;
    }
};

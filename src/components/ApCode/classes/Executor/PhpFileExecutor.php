<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Executor;

class PhpFileExecutor implements RuntimeInterface
{
    protected $action;
    protected $baseDir;

    private $args;
    private $params;
    private $scope;

    public function __construct($baseDir = '')
    {
        $this->baseDir = $baseDir ? rtrim($baseDir, '/') .'/' : '';
        $this->scope   = [];
    }

    protected function prepareAction($action)
    {
        return $action;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\ExecutorInterface::canExecute()
     */
    public function canExecute($action, ...$argsAndLastParams)
    {
        $this->action = $this->prepareAction($action);
        return $this->actionExists();
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\ExecutorInterface::execute()
     */
    public function execute($action, ...$argsAndLastParams)
    {
        $this->action = $this->prepareAction($action);

        if (!$this->actionExists()) {
            throw new Exception("Invalid action ". $this->getActionFile());
        }

        $args   = $this->args;
        $params = $this->params;

        $this->setArgsAndParams($argsAndLastParams);

        $result = $this->doAction();

        $this->args   = $args;
        $this->params = $params;

        return $result;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\ExecutorInterface::executeOnce()
     */
    public function executeOnce($action, ...$argsAndLastParams)
    {
        $this->action = $this->prepareAction($action);

        if (!$this->actionExists()) {
            throw new Exception("Invalid action ". $this->getActionFile());
        }

        $args   = $this->args;
        $params = $this->params;

        $this->setArgsAndParams($argsAndLastParams);

        $result = $this->doActionOnce();

        $this->args   = $args;
        $this->params = $params;

        return $result;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\ExecutorInterface::executeIfExists()
     */
    public function executeIfExists($action, ...$argsAndLastParams)
    {
        $this->action = $this->prepareAction($action);

        if (!$this->actionExists()) {
            return null;
        }

        $args   = $this->args;
        $params = $this->params;

        $this->setArgsAndParams($argsAndLastParams);

        $result = $this->doAction();

        $this->args   = $args;
        $this->params = $params;

        return $result;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\ExecutorInterface::executeOnceIfExists()
     */
    public function executeOnceIfExists($action, ...$argsAndLastParams)
    {
        $this->action = $this->prepareAction($action);

        if (!$this->actionExists()) {
            return null;
        }

        $args   = $this->args;
        $params = $this->params;

        $this->setArgsAndParams($argsAndLastParams);

        $result = $this->doActionOnce();

        $this->args   = $args;
        $this->params = $params;

        return $result;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\ExecutorInterface::include()
     */
    public function include($action)
    {
        $this->action = $this->prepareAction($action);

        if (!$this->actionExists()) {
            throw new Exception("Invalid action: " . $this->getActionFile());
        }

        $result = $this->doAction();

        return $result;
    }

    protected function doAction()
    {
        return include $this->getActionFile();
    }

    protected function doActionOnce()
    {
        return include_once $this->getActionFile();
    }

    protected function actionExists()
    {
        return file_exists($this->getActionFile());
    }

    protected function getActionFile()
    {
        if (substr($this->action, 0, 1) === '/') {
            return $this->action;
        }

        return $this->baseDir ? ($this->baseDir . $this->action) : $this->action;
    }

    protected function setArgsAndParams($argsAndParams)
    {
        $last = end($argsAndParams);

        if (is_array($last)) {
            $this->params = $last;
        } else {
            $this->params = [];
        }

        $this->args = $argsAndParams;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\RuntimeInterface::setScopeVar()
     */
    public function argument($index = 0, $default = NULL)
    {
        return $this->args[$index] ?? $default;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\RuntimeInterface::param()
     */
    public function param($name, $default = NULL)
    {
        return $this->params[$name] ?? $default;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\RuntimeInterface::scopeVar()
     */
    public function scopeVar($name, $default = NULL)
    {
        return $this->scope[$name] ?? $default;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\RuntimeInterface::setScopeVar()
     */
    public function setScopeVar($name, $value)
    {
        $this->scope[$name] = $value;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\RuntimeInterface::hasArgument()
     */
    public function hasArgument($index = 0)
    {
        return isset($this->args[$index]);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\RuntimeInterface::hasParam()
     */
    public function hasParam($name)
    {
        return isset($this->params[$name]);
    }

    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\RuntimeInterface::hasScopeVar()
     */
    public function hasScopeVar($name)
    {
        return isset($this->scope[$name]);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\RuntimeInterface::argumentList()
     */
    public function argumentList()
    {
        return $this->args;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\RuntimeInterface::paramList()
     */
    public function paramList()
    {
        return $this->params;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Executor\RuntimeInterface::scopeVarList()
     */
    public function scopeVarList()
    {
        return $this->scope;
    }
}

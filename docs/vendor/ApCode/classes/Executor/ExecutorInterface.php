<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Executor;

interface ExecutorInterface
{
    /**
     * Выполнить действие в текущем контексте
     * @param string $action
     */
    function include($action);
    
    /**
     * Можно ли выполнить действие
     * 
     * @param string $action
     * @param mixed ...$argsAndLastParams
     */
    function canExecute($action, ...$argsAndLastParams);
    
    /**
     * Выполнить действие
     * 
     * @param string $action
     * @param mixed ...$argsAndLastParams
     */
    function execute($action, ...$argsAndLastParams);
    
    /**
     * Выполнить действие только один раз
     * 
     * @param string $action
     * @param mixed ...$argsAndLastParams
     */
    function executeOnce($action, ...$argsAndLastParams);
    
    /**
     * Выполнить действие, если оно есть
     * 
     * @param string $action
     * @param mixed ...$argsAndLastParams
     */
    function executeIfExists($action, ...$argsAndLastParams);
    
    /**
     * Выполнить действие, если оно есть, только один раз
     * 
     * @param string $action
     * @param mixed ...$argsAndLastParams
     */
    function executeOnceIfExists($action, ...$argsAndLastParams);
}
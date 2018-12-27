<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Executor;

interface RuntimeInterface extends ExecutorInterface
{
    /**
     * Возвращает аргумент действия. Используется в скриптах действий.
     * 
     * @param number $index
     * @param mixed $default
     */
    function argument($index = 0, $default = NULL);
    
    /**
     * Возвращает TRUE, если есть аргумент
     * 
     * @param number $index
     */
    function hasArgument($index = 0);
    
    /**
     * Возвращает список аргументов
     */
    function argumentList();
    
    /**
     * Возвращает параметр действия. Используется в скриптах действий.
     * 
     * @param string $index
     * @param mixed $default
     */
    function param($name, $default = NULL);
    
    /**
     * Установить параметр
     * 
     * @param string $name
     * @param mixed $value
     */
    function setParam($name, $value);
    
    /**
     * Возвращает TRUE, есть есть параметр
     * 
     * @param unknown $name
     */
    function hasParam($name);
    
    /**
     * Возвращает список параметров
     */
    function paramList();
    
    /**
     * Возвращает переменную из области выполнения
     * 
     * @param string $name
     * @param mixed $default
     */
    function scopeVar($name, $default = NULL);
    
    /**
     * Возвращает TRUE, если есть переменная области выполнения
     * 
     * @param string $name
     */
    function hasScopeVar($name);
    
    /**
     * Список переменных области выполнения
     */
    function scopeVarList();
    
    /**
     * Устанавливает переменную области выполнения
     * 
     * @param string $name
     * @param mixed $value
     */
    function setScopeVar($name, $value);
}
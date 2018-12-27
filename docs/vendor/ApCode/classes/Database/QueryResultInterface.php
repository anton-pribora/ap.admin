<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Database;

interface QueryResultInterface
{
    /**
     * Время выполнения запроса
     */
    function elapsedTime();
    
    /**
     * Количество затронутых строк
     */
    function affected();
    
    /**
     * Получить значение текущей строки
     */
    function fetchValue();
    
    /**
     * Получить все значения первого столбца
     */
    function fetchColumn();
    
    /**
     * Получить строку как ассоциативный массив
     */
    function fetchRow();
    
    /**
     * Получить все строки как ассоциативный массив
     */
    function fetchAllRows();
    
    /**
     * Получить строку как объект указанного класса
     * 
     * @param string $class                 Класс объекта
     * @param mixed  $constructorArguments  Аргументы, которые передаются в конструктор
     */
    function fetchObject($class = NULL, $constructorArguments = NULL);
    
    /**
     * Получить все строки как массив объектов указанного класса
     *
     * @param string $class                 Класс объекта
     * @param mixed  $constructorArguments  Аргументы, которые передаются в конструктор
     */
    function fetchAllObjects($class = NULL, $constructorArguments = NULL);
    
    /**
     * Получить список всех столбцов выборки
     */
    function columns();
    
    /**
     * Очистить ресурсы по данному запросу
     */
    function free();
}
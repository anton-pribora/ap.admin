<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Web;

interface UrlManagerInterface
{
    /**
     * Установить параметр, который будет добавляться во все ссылки
     * 
     * @param string $name
     * @param mixed $value
     */
    function setStaticParam($name, $value);
    
    /**
     * Установить параметры, которые будут добавляться во все ссылки
     * 
     * @param array $params
     */
    function setStaticParams($params);
    
    /**
     * Сделать параметр статичным
     * 
     * @param string $name
     */
    function makeStaticParam($name);
    
    /**
     * Сделать параметры статичными
     * 
     * @param array $name
     */
    function makeStaticParams($params);
    
    /**
     * Получить параметры, которые устанавливаются во все ссылки
     * 
     * @return array
     */
    function getStaticParams();
    
    /**
     * Короткая ссылка без домена
     * 
     * @param string $path
     * @param array $params
     * @param bool $replaceParams
     * @return \ApCode\Web\Url
     */
    function shortUrl($path, $params = [], $replaceParams = FALSE);
    
    /**
     * Полная ссылка
     * 
     * @param string $path
     * @param array $params
     * @param bool $replaceParams
     * @return \ApCode\Web\Url
     */
    function fullUrl($path, $params = [], $replaceParams = FALSE);
    
    /**
     * Проверить, совпадает ли $path с началом путь текущей ссылки
     * 
     * @param string $path
     */
    function matchPath($path);
}
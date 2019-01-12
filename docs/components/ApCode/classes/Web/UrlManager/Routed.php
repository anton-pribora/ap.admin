<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Web\UrlManager;

use ApCode\Web\RequestInterface;
use ApCode\Web\Url;

class Routed extends \ApCode\Web\UrlManager
{
    private $routes = [];
    
    function addRoutes($routes)
    {
        $this->routes = array_merge($this->routes, $routes);
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Web\UrlManager::shortUrl()
     */
    function shortUrl($path, $params = [], $replaceParams = FALSE)
    {
        return $this->applyRoutesToUrl(parent::shortUrl($path, $params, $replaceParams));
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Web\UrlManager::fullUrl()
     */
    function fullUrl($path, $params = [], $replaceParams = FALSE)
    {
        return $this->applyRoutesToUrl(parent::fullUrl($path, $params, $replaceParams));
    }
    
    private function applyRoutesToUrl(Url $url)
    {
        foreach ($this->routes as $route) {
            $newUrl  = $this->alias->expand($route['url']);
            $action  = $this->alias->expand($route['action']);
            
            if (strncmp($url->getPath(), $action, strlen($action)) === 0) {
                $newPath = preg_replace_callback('~\{(\w+)\}~', function($matches) use($url) {
                    $param = $url->getQueryParam($matches[1]);
                    $url->setQueryParam($matches[1], null);
                    return $param;
                }, $newUrl);
                
                if (substr($action, -1, 1) == '/') {
                    $newPath = substr_replace($url->getPath(), $newPath, 0, strlen($action));
                }
                
                $url->setPath($newPath);
            }
        }
        
        $url->setPath(strtr($url->getPath(), ['.php' => '.html']));
        
        return $url;
    }
    
    function applyRoutes(RequestInterface $request)
    {
        $requestAction = $request->action();
        
        foreach ($this->routes as $route) {
            $pattern = $this->alias->expand($route['pattern']);
            $action  = $this->alias->expand($route['action']);
            
            if (preg_match($pattern, $requestAction, $matches)) {
                $action = $this->alias->expand($action);
                
                if (substr($action, -1, 1) == '/') {
                    $request->setAction($action . end($matches));
                } else {
                    $request->setAction($action);
                }
                
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $request->set($key, $value);
                        $this->origin->setQueryParam($key, $value);
                        $this->shortUrl->setQueryParam($key, $value);
                        $this->fullUrl->setQueryParam($key, $value);
                    }
                }
                
                $path = $this->shortUrl->getPath();
                
                if (substr($action, -1, 1) == '/') {
                    preg_match($pattern, $path, $matches);
                    $path = $action . end($matches);
                }
                
                $this->origin->setPath($path);
                $this->shortUrl->setPath($path);
                $this->fullUrl->setPath($path);
                
                break;
            }
        }
        
        $requestAction = $request->action();
        $request->setAction(strtr($requestAction, ['.html' => '.php', '.xml' => '.php']));
    }
}
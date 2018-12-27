<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Web;

use ApCode\Alias\AliasInterface;

class UrlManager implements UrlManagerInterface
{
    protected $fullUrl;
    protected $shortUrl;
    protected $origin;
    protected $alias;
    
    private $params = [];
    
    public function __construct($fullUrl, AliasInterface $alias)
    {
        if ($fullUrl instanceof Url) {
            $this->origin = clone $fullUrl;            
        } else {
            $this->origin = new Url($fullUrl);
        }
        
        $this->fullUrl = clone $this->origin;
        $this->fullUrl->removeQueryParams();
        $this->fullUrl->removeFragment();
        
        $this->shortUrl = clone $this->fullUrl;
        $this->shortUrl->setHost(null);
        
        $this->alias = $alias;
    }
    
    public function setAlias($alias, $value)
    {
        $this->alias->set($alias, $value);
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Web\UrlManagerInterface::setStaticParam()
     */
    public function setStaticParam($name, $value)
    {
        $this->params[$name] = $value;
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Web\UrlManagerInterface::setStaticParams()
     */
    public function setStaticParams($params)
    {
        $this->params = array_merge($this->params, $params);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Web\UrlManagerInterface::queryUri()
     */
    public function shortUrl($path, $params = array(), $replaceParams = FALSE)
    {
        $url = new Url($this->alias->expand($path), $this->shortUrl);
        
        if ($replaceParams) {
            $url->setQueryParams($params);
        } else {
            $url->addQueryParams(array_merge($this->params, $params));
        }
        
        return $url;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Web\UrlManagerInterface::fullUri()
     */
    public function fullUrl($path, $params = array(), $replaceParams = FALSE)
    {
        $url = new Url($this->alias->expand($path), $this->fullUrl);
        
        if ($replaceParams) {
            $url->setQueryParams($params);
        } else {
            $url->addQueryParams(array_merge($this->params, $params));
        }
        
        return $url;
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Web\UrlManagerInterface::matchPath()
     */
    public function matchPath($path)
    {
        if ($path instanceof Url) {
            $url = $path;
        } else {
            $url = new Url($this->alias->expand($path), $this->shortUrl);
        }
        
        return substr_compare($this->shortUrl('')->getPath(), $url->getPath(), 0, strlen($url->getPath())) == 0;
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Web\UrlManagerInterface::getStaticParams()
     */
    public function getStaticParams()
    {
        return $this->params;
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Web\UrlManagerInterface::makeStaticParam()
     */
    public function makeStaticParam($name)
    {
        $this->setStaticParam($name, $this->origin->getQueryParam($name));
        
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Web\UrlManagerInterface::makeStaticParams()
     */
    public function makeStaticParams($params)
    {
        foreach ($params as $name) {
            $this->makeStaticParam($name);
        }
        
        return $this;
    }

}
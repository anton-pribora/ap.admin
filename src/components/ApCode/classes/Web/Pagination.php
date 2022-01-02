<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Web;

class Pagination extends \ApCode\Misc\Pagination
{
    private $pageParamName = 'page';
    private $limitParamName = 'limit';
    
    /**
     * @var Url
     */
    private $url;
    
    public function setPageParamName($name)
    {
        $this->pageParamName = $name;
        return $this;
    }
    
    public function pageParamName()
    {
        return $this->pageParamName;
    }
    
    public function setLimitParamName($name)
    {
        $this->limitParamName = $name;
        return $this;
    }
    
    public function limitParamName()
    {
        return $this->limitParamName;
    }
    
    /**
     * @return \ApCode\Web\Url
     */
    public function url()
    {
        return $this->url;
    }
    
    public function setUrl(Url $url, $setParamsFromUrl = TRUE)
    {
        $this->url = $url;
        
        if ($setParamsFromUrl && $url->hasQueryParam($this->pageParamName)) {
            $this->setPage($url->getQueryParam($this->pageParamName));
        }
        
        if ($setParamsFromUrl && $url->hasQueryParam($this->limitParamName)) {
            $this->setLimit($url->getQueryParam($this->limitParamName));
        }
        
        return $this;
    }
    
    public function pageUrl($page)
    {
        $this->url->setQueryParam($this->pageParamName, $page);
        return (string) $this->url;
    }
}
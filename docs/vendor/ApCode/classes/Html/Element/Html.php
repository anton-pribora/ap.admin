<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class Html extends ContentableElement
{
    protected $tagName = 'html';

    /**
     * 
     * @var Head
     */
    protected $head = null;
    
    /**
     * 
     * @var Body
     */
    protected $body = null;
    
    protected function initialize()
    {
        $this->head = $this->createSubElement(Head::class);
        $this->body = $this->createSubElement(Body::class);
    }
    
    /**
     * 
     * @return HtmlHead
     */
    public function head()
    {
        return $this->head;
    }
    
    public function addContents($contents)
    {
        return $this->body->addContents($contents);
    }
    
    public function addHtml($html)
    {
        return $this->body->addHtml($html);
    }
    
    /**
     * 
     * @return HtmlBody
     */
    public function body()
    {
        return $this->body;
    }
    
    /**
     * Set Application cache manifest
     * 
     * @param $value
     */
    function setManifest($value)
    {
        $this->setAttribute("manifest", $value);
        return $this;
    }

    /**
     * Get Application cache manifest
     */
    function getManifest()
    {
        return $this->getAttribute("manifest");
    }
}

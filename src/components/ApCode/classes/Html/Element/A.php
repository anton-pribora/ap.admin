<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Html\Element;

class A extends ContentableElement
{
    protected $tagName = 'a';

    public function __construct($contents = null, $href = null, $title = NULL)
    {
        parent::__construct($contents);

        if ( isset($href) ) {
            $this->setHref($href);
        }

        if ( isset($title) ) {
            $this->setTitle($title);
        }
    }

    /**
     * Set Address of the hyperlink
     *
     * @param $value
     */
    function setHref($value)
    {
        if ( $value === false ) {
            $value = 'javascript:void(0)';
        }

        $this->setAttribute("href", $value);
        return $this;
    }

    /**
     * Get Address of the hyperlink
     */
    function getHref()
    {
        return $this->getAttribute("href");
    }

    /**
     * Set Default browsing context for hyperlink navigation and form submission
     *
     * @param $value
     */
    function setTarget($value)
    {
        $this->setAttribute("target", $value);
        return $this;
    }

    /**
     * Get Default browsing context for hyperlink navigation and form submission
     */
    function getTarget()
    {
        return $this->getAttribute("target");
    }

    /**
     * Set Whether to download the resource instead of navigating to it, and its file name if so
     *
     * @param $value
     */
    function setDownload($value)
    {
        $this->setAttribute("download", $value);
        return $this;
    }

    /**
     * Get Whether to download the resource instead of navigating to it, and its file name if so
     */
    function getDownload()
    {
        return $this->getAttribute("download");
    }

    /**
     * Set Relationship between the document containing the hyperlink and the destination resource
     *
     * @param $value
     */
    function setRel($value)
    {
        $this->setAttribute("rel", $value);
        return $this;
    }

    /**
     * Get Relationship between the document containing the hyperlink and the destination resource
     */
    function getRel()
    {
        return $this->getAttribute("rel");
    }

    /**
     * Set Language of the linked resource
     *
     * @param $value
     */
    function setHreflang($value)
    {
        $this->setAttribute("hreflang", $value);
        return $this;
    }

    /**
     * Get Language of the linked resource
     */
    function getHreflang()
    {
        return $this->getAttribute("hreflang");
    }

    /**
     * Set Hint for the type of the referenced resource
     *
     * @param $value
     */
    function setType($value)
    {
        $this->setAttribute("type", $value);
        return $this;
    }

    /**
     * Get Hint for the type of the referenced resource
     */
    function getType()
    {
        return $this->getAttribute("type");
    }
}

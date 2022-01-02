<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Mail\Message;

class Part
{
    protected $headers = null;
    protected $content = null;
    
    public function __construct()
    {
        $this->headers = new Headers();
    }
    
    public function isHtml()
    {
        return preg_match('~html~i', $this->getContentType());
    }
    
    public function isAttachmentOrRelation()
    {
        return !is_null($this->getContentDisposition());
    }
    
    public function setHeader($header, $value)
    {
        $this->headers->set($header, $value);
        return $this;
    }
    
    public function setHeaders($headers)
    {
        foreach ( $headers as $header => $value ) {
            $this->setHeader($header, $value);
        }
        
        return $this;
    }
    
    public function setContentType($type)
    {
        $this->headers->set('Content-type', $type);
        return $this;
    }
    
    public function getContentType()
    {
        return $this->headers->getFirst('Content-type');
    }
    
    public function setContentId($id)
    {
        $this->headers->set('Content-ID', "<$id>");
        return $this;
    }
    
    public function setContentDisposition($disposition)
    {
        $this->headers->set('Content-disposition', $disposition);
        return $this;
    }
    
    public function getContentDisposition()
    {
        return $this->headers->getFirst('Content-disposition');
    }
    
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
    
    public function addContent($content)
    {
        $this->content .= $content;
        return $this;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function includeContent( $path )
    {
        $this->content = file_get_contents($path);
        return $this;
    }
    
    public function __toString()
    {
        $content = $this->encodeContent();
        return $this->headers ."\r\n". $content ."\r\n";
    }
    
    private function encodeContent()
    {
        if ( true || !preg_match('~^text/~i', $this->getContentType()) ) {
            $this->setContentTransferEncodig('base64');
            return trim(chunk_split(base64_encode((string) $this->getContent())));
        }
        
        $this->setContentTransferEncodig('8bit');
        return trim(chunk_split((string) $this->getContent()));
    }
    
    private function setContentTransferEncodig($encoding)
    {
        $this->headers->set('Content-Transfer-Encoding', $encoding);
    }
}
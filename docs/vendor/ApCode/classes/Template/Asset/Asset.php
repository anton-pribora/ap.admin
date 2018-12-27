<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Template\Asset;

use ApCode\Alias\AliasInterface;

class Asset implements AssetInterface
{
    private $pathAlias;
    private $urlAlias;

    private $folders = [];
    
    public function __construct(AliasInterface $pathAlias, AliasInterface $urlAlias)
    {
        $this->pathAlias = $pathAlias;
        $this->urlAlias  = $urlAlias;
    }
    
    private function addFolder($folder)
    {
        $key = substr(sha1($folder), -6);
        
        if (empty($this->folders[$key])) {
            $link = $this->pathAlias->expand("@assetpath/$key");
            
            if (!file_exists($link)) {
                symlink($folder, $link);
            }
            
            $this->folders[$key] = ["@asseturl/$key/", $folder];
        }
        
        return $this->folders[$key][0]; 
    }
    
    public function urlTo($path, $autoExpandPath = TRUE)
    {
        if (empty($path) && $path !== '0') {
            throw new \Exception("Path is empty");
        }
        
        if ($autoExpandPath) {
            $path = $this->pathAlias->expand($path);
        }
        
        if (!file_exists($path)) {
            throw new \Exception('Path "'. $path .'" does not exist');
        }
        
        $realpath = realpath($path);
        
        if ($realpath == '/') {
            throw new \Exception('You can not asset root folder /');
        }
        
        if (is_dir($realpath)) {
            $dirname  = $realpath .'/';
            $filename = '';
        } else {
            $dirname  = dirname($realpath) .'/';
            $filename = basename($realpath);
        }
        
        foreach ($this->folders as $key => list($url, $folder)) {
            if (substr_compare($dirname, $folder, 0, strlen($folder)) == 0) {
                return $this->urlAlias->expand($url) . substr($realpath, strlen($folder));
            }
        }
        
        $url = $this->addFolder($dirname);
        
        return $this->urlAlias->expand($url) . $filename;
    }
}
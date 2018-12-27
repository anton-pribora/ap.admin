<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Misc\FileMeta;

class FileMeta implements FileMetaInterface
{
    private $metaFilename;
    private $storage = [];
    
    public function __construct($targetFile)
    {
        if (is_file($targetFile)) {
            $pathinfo = pathinfo($targetFile);
            $this->metaFilename = "$pathinfo[dirname]/$pathinfo[filename].meta.php";
        } else {
            $this->metaFilename = $targetFile .'/folder.meta.php';
        }
        
        if (file_exists($this->metaFilename)) {
            $this->storage = include $this->metaFilename;
        }
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Misc\FileMeta\FileMetaInterface::metaFileName()
     */
    public function metaFileName()
    {
        return $this->metaFilename;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Misc\FileMeta\FileMetaInterface::has()
     */
    public function has($name)
    {
        return isset($this->storage[$name]);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Misc\FileMeta\FileMetaInterface::get()
     */
    public function get($name, $default = NULL)
    {
        return $this->has($name) ? $this->storage[$name] : $default;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Misc\FileMeta\FileMetaInterface::set()
     */
    public function set($name, $value)
    {
        $this->storage[$name] = $value;
        return $this;
    }
    
    public function toArray()
    {
        return $this->storage;
    }
}
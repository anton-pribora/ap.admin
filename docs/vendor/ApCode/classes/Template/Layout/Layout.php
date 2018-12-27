<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Template\Layout;

use ApCode\Alias\AliasInterface;
use ApCode\Template\Layout\Renderer\RendererInterface;

class Layout implements LayoutInterface
{
    /**
     * @var RendererInterface[]
     */
    private $renders     = [];
    private $blocks      = [];
    private $vars        = [];
    private $grabInto    = [];
    private $initialized = false;

    private $layoutFolder;
    private $alias;

    public function __construct($layoutFolder = NULL, AliasInterface $PathAlias = NULL)
    {
        $this->layoutFolder = $layoutFolder;
        $this->alias        = $PathAlias;
    }

    public function append($blockId, $value, $data = [])
    {
        if (isset($this->blocks[$blockId])) {
            $this->blocks[$blockId][] = [$value, $data];
        } else {
            $this->blocks[$blockId] = [[$value, $data]];
        }

        return $this;
    }

    public function appendOnce($blockId, $value, $data = [])
    {
        if (isset($this->blocks[$blockId])) {
            foreach ($this->blocks[$blockId] as list($blockValue, $blockData)) {
                if ($blockValue == $value) {
                    return $this;
                }
            }
        }

        $this->append($blockId, $value, $data);

        return $this;
    }

    public function prepend($blockId, $value, $data = [])
    {
        if (isset($this->blocks[$blockId])) {
            array_unshift($this->blocks[$blockId], [$value, $data]);
        } else {
            $this->blocks[$blockId] = [[$value, $data]];
        }

        return $this;
    }

    public function prependOnce($blockId, $value, $data = [])
    {
        if (isset($this->blocks[$blockId])) {
            foreach ($this->blocks[$blockId] as list($blockValue, $blockData)) {
                if ($blockValue == $value) {
                    return $this;
                }
            }
        }

        $this->prepend($blockId, $value, $data);

        return $this;
    }

    public function remove($blockId)
    {
        unset($this->blocks[$blockId]);
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\LayoutInterface::retrieve()
     */
    public function retrieve($blockId)
    {
        $result = null;

        if (isset($this->blocks[$blockId])) {
            $result = $this->blocks[$blockId];
        }

        return $result;
    }

    public function render($blockId, RendererInterface $renderer = null)
    {
        if (empty($renderer) && isset($this->renders[$blockId])) {
            $renderer = $this->renders[$blockId];
        }

        if (empty($renderer)) {
            $renderer = new Renderer\Html();
        }

        $blockValues = isset($this->blocks[$blockId]) ? $this->blocks[$blockId] : [];
        $values = [];

        foreach ($blockValues as list($value, $data)) {
            $values[] = $renderer->renderValue($value, $data);
        }

        return $renderer->renderResult($values);
    }

    public function renderIfNotEmpty($blockId, RendererInterface $renderer = null)
    {
        if (empty($this->blocks[$blockId])) {
            return null;
        }

        return $this->render($blockId, $renderer);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\LayoutInterface::setRenderer()
     */
    public function setRenderer($blockId, RendererInterface $renderer)
    {
        $this->renders[ $blockId ] = $renderer;
        return $this;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\LayoutInterface::setRendererIfEmpty()
     */
    public function setRendererIfEmpty($blockId, RendererInterface $renderer)
    {
        if (empty($this->renders[$blockId])) {
            $this->renders[ $blockId ] = $renderer;
        }

        return $this;
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\LayoutInterface::setVar()
     */
    public function setVar($varname, $value)
    {
        $this->vars[$varname] = $value;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\LayoutInterface::getVar()
     */
    public function getVar($varname, $default = NULL)
    {
        if ($this->hasVar($varname)) {
            return $this->vars[$varname];
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\LayoutInterface::hasVar()
     */
    public function hasVar($varname)
    {
        return isset($this->vars[$varname]);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\LayoutInterface::exists()
     */
    public function exists($blockId)
    {
        return isset($this->blocks[$blockId]);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\LayoutInterface::startGrab()
     */
    public function startGrab($blockId)
    {
        $this->grabInto[] = $blockId;
        ob_start();
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\LayoutInterface::endGrab()
     */
    public function endGrab()
    {
        $this->append(array_pop($this->grabInto), ob_get_clean());
    }
    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\LayoutInterface::reset()
     */
    public function reset()
    {
        $this->blocks  = [];
        $this->vars    = [];
        $this->renders = [];

        $this->initialized = false;
    }

    private function init()
    {
        if (!$this->initialized) {
            foreach (glob($this->layoutPath('init/*.php')) as $file) {
                include $file;
            }

            $this->initialized = true;
        }
    }

    private function layoutPath($file = NULL)
    {
        if ($this->alias) {
            $folder = $this->alias->expand($this->layoutFolder);
        } else {
            $folder = $this->layoutFolder;
        }

        return rtrim($folder, '/') .'/'. ltrim($file, '/');
    }

    function setLayoutFolder($folder)
    {
        $this->layoutFolder = $folder;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Template\Layout\LayoutInterface::display()
     */
    public function display($returnAsString = NULL)
    {
        if (empty($this->layoutFolder)) {
            throw new \Exception('You must to specify the layout script folder');
        }

        $this->init();

        if ($returnAsString) {
            ob_start();
        }

        require $this->layoutPath('layout.php');

        if ($returnAsString) {
            return ob_get_clean();
        }
    }
}
<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class PhpInterface extends PhpElement
{
    private $style;

    protected $namespace = null;
    protected $extensions = [];
    protected $functions = [];

    public function __construct($name, PhpNamespace $namespace = null)
    {
        parent::__construct($name);

        if ( isset($namespace) )
        {
            $this->setNamespace($namespace);
        }
    }

    public function getFullName(PhpNamespace $currentNamespace = null)
    {
        if ( $this->hasNamespace() )
        {
            if ( isset($currentNamespace) )
            {
                $path = preg_replace('~^'. preg_quote($currentNamespace->getName()) .'\b\\\\?~', '', $this->namespace->getName(), 1, $count);

                if ( $count )
                {
                    return $path ? $path .'\\'. $this->getName() : $this->getName();
                }
                else
                {
                    return '\\'. $this->namespace->getName() .'\\'. $this->getName();
                }
            }
            else
            {
                return '\\'. $this->namespace->getName() .'\\'. $this->getName();
            }
        }
        else
        {
            return '\\'. $this->getName();
        }
    }

    public function setNamespace(PhpNamespace $namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function hasNamespace()
    {
        return mb_strlen($this->namespace) > 0;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function hasExtensions()
    {
        return count($this->extensions) > 0;
    }

    public function getExtensions()
    {
        return $this->extensions;
    }

    public function addExtension(PhpInterface $extension)
    {
        $this->extensions[] = $extension;
        return $this;
    }

    public function hasFunctions()
    {
        return count($this->functions) > 0;
    }

    /**
     * @return PhpFunction[]
     */
    public function getFunctions()
    {
        return $this->functions;
    }

    public function createFunction($name)
    {
        $function = new PhpFunction($name);
        $this->functions[] = $function;

        return $function;
    }

    public function style()
    {
        if (empty($this->style)) {
            $this->style = new Style();
        }

        return $this->style;
    }

    public function setStyle(Style $style)
    {
        $this->style = $style;
        return $this;
    }

    public function render()
    {
        return $this->style()->render($this);
    }
}

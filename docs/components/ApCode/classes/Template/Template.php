<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Template;

use ApCode\Alias\Alias;
use ApCode\Executor\PhpFileExecutor;
use ApCode\Alias\AliasInterface;

class Template extends PhpFileExecutor implements TemplateInterface
{
    private $alias;

    public function setAlias(AliasInterface $alias)
    {
        $this->alias = $alias;
    }
    
    public function getAlias()
    {
        return $this->alias;
    }
    
    /**
     * {@inheritDoc}
     * @see \ApCode\Template\TemplateInterface::render()
     */
    public function render($scriptName, ...$params)
    {
        if ($this->alias) {
            $scriptName = $this->alias->expand($scriptName);
        }
        
        return $this->execute($scriptName, ...$params);
    }
}
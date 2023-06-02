<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Codebuilder;

class Style
{
    protected $indent = '    ';
    protected $options = [
        'function' => [
            'phpdoc' => TRUE,
        ],
    ];

    public function render(PhpElement $element)
    {
        if ( $element instanceof PhpClass ) {
            return $this->renderClass($element);
        }
        elseif ( $element instanceof PhpInterface ) {
            return $this->renderInterface($element);
        }
        elseif ($element instanceof PhpFunction) {
            return $this->renderFunction($element);
        }
        else
        {
            return print_r($element, true);
        }
    }

    public function setOption($key, $value)
    {
        $key = "'" . strtr($key, ['.' => "']['"]) . "'";
        eval("\$this->options[$key] = \$value;");
    }

    public function getOption($key, $default = NULL)
    {
        $key = "'" . strtr($key, ['.' => "']['"]) . "'";
        return eval("return \$this->options[$key] ?? \$defult;");
    }

    protected function renderInterface(PhpInterface $interface)
    {
        $fileBlocks = [];

        if ( $interface->hasNamespace() )
        {
            $fileBlocks[] = 'namespace '. $interface->getNamespace() .';';
        }

        $classBlocks = [];
        $result      = [];

        $phpdoc = new PhpDoc();
        $phpdoc->addBody($interface->getDescription());

        if ( $phpdoc->hasContents() )
        {
            $result = $phpdoc->toArray();
        }

        $result[] = $this->renderInterfaceDefinition($interface);
        $result[] = '{';

        foreach ( $interface->getFunctions() as $function )
        {
            $classBlocks[] = $this->renderFunction($function);
        }

        $result[] = join(PHP_EOL . PHP_EOL, $classBlocks);
        $result[] = '}';

        $fileBlocks[] = join(PHP_EOL, $result);

        return join(PHP_EOL . PHP_EOL, $fileBlocks);
    }

    protected function renderClass(PhpClass $class)
    {
        $fileBlocks = [];

        if ( $class->hasNamespace() )
        {
            $fileBlocks[] = 'namespace '. $class->getNamespace() .';';
        }

        $classBlocks = [];
        $result      = [];

        $phpdoc = new PhpDoc();
        $phpdoc->addBody($class->getDescription());

        if ( $phpdoc->hasContents() )
        {
            $result = $phpdoc->toArray();
        }

        $result[] = $this->renderClassDefinition($class);
        $result[] = '{';

        if ($class->hasTraits()) {
            foreach ($class->getTraits() as $trait) {
                $result[] = $this->indent . "use {$trait};";
            }

            $result[] = '';
        }

        foreach ( $class->getPropertyGroups() as $group )
        {
            $classBlocks[] = $this->renderGroupOfProperties($group);
        }

        foreach ( $class->getProperties() as $property )
        {
            $classBlocks[] = $this->renderProperty($property);
        }

        foreach ( $class->getFunctions() as $function )
        {
            $classBlocks[] = $this->renderFunction($function);
        }

        $result[] = join(PHP_EOL . PHP_EOL, $classBlocks);
        $result[] = '}';

        $fileBlocks[] = join(PHP_EOL, $result);

        return join(PHP_EOL . PHP_EOL, $fileBlocks);
    }

    protected function renderInterfaceDefinition(PhpInterface $interface)
    {
        $definition = [];

        $definition[] = 'interface';
        $definition[] = $interface->getName();

        if ( $interface->hasExtensions() )
        {
            $definition[] = 'extends';

            $list = [];

            foreach ( $interface->getExtensions() as $extension )
            {
                $list[] = $extension->getName();
            }

            $definition[] = join(', ', $list);
        }

        return join(' ', $definition);
    }

    protected function renderClassDefinition(PhpClass $class)
    {
        $definition = [];

        if ( $class->isAbstract() )
        {
            $definition[] = 'abstract';
        }

        $definition[] = 'class';
        $definition[] = $class->getName();

        if ( $class->hasExtensions() )
        {
            $definition[] = 'extends';

            $list = [];

            foreach ( $class->getExtensions() as $extension )
            {
                $list[] = $extension->getFullName($class->getNamespace());
            }

            $definition[] = join(', ', $list);
        }

        if ( $class->hasImplementations() )
        {
            $definition[] = 'implements';

            $list = [];

            foreach ( $class->getImplementations() as $implementation )
            {
                $list[] = $implementation->getFullName($class->getNamespace());
            }

            $definition[] = join(', ', $list);
        }

        return join(' ', $definition);
    }

    protected function renderGroupOfProperties(PhpGroupOfProperties $group)
    {
        $result  = [];
        $padding = $group->getMaxNameLen();
        $format  = '%s $%-'. $padding .'s = %s;';

        $commentPosition = $group->getMaxDefinitionLen() + 10;
        $commentFormat   = '%-'. $commentPosition .'s  // %s';

        foreach ( $group->getProperties() as $property )
        {
            $definition = sprintf($format, $property->getAccessType(), $property->getName(), $property->getDefaultValue()->render($this->indent));

            if ( $property->hasDescription() )
            {
                foreach ($property->getDescription() as $description)
                {
                    $result[]   = $this->indent . sprintf($commentFormat, $definition, $description);
                    $definition = '';
                }
            }
            else
            {
                $result[] = $this->indent . $definition;
            }
        }

        return join(PHP_EOL, $result);
    }

    protected function renderProperty(PhpClassProperty $property)
    {
        $result = [];
        $definition = [];

        $phpdoc = new PhpDoc();
        $phpdoc->addBody($property->getDescription());

        if ( $property->hasRequiredType() )
        {
            $phpdoc->addKeyword('var', (string) $property->getRequiredType());
        }

        if ( $phpdoc->hasContents() )
        {
            foreach ( $phpdoc->toArray() as $line )
            {
                $result[] = $this->indent . $line;
            }
        }

        $definition[] = $property->getAccessType();

        if ( $property->isStatic() )
        {
            $definition[] = 'static';
        }

        $definition[] = '$'. $property->getName();
        $definition[] = '=';

        $defaultValue = $property->getDefaultValue();

        if ( $defaultValue->isMultiLine() )
        {
            $lines = $defaultValue->getDefinitionAsLineArray($this->indent);
            $definition[] = array_shift($lines);

            $result[] = $this->indent . join(' ', $definition);

            foreach ( $lines as $line )
            {
                $result[] = $this->indent . $line;
            }

            $result[ count($result) - 1 ] .= ';';
        }
        else
        {
            $definition[] = $property->getDefaultValue()->render($this->indent) .';';
            $result[] = $this->indent . join(' ', $definition);
        }

        return join(PHP_EOL, $result);
    }

    protected function renderFunction(PhpFunction $function)
    {
        $result = [];
        $list   = [];
        $phpdoc = new PhpDoc();

        $phpdoc->addBody($function->getDescription());

        foreach ( $function->getArguments() as $argument )
        {
            $definition = [];

            $types = [];

            if ( $argument->hasRequiredType() )
            {
                $types[]      = (string) $argument->getRequiredType();
                $definition[] = (string) $argument->getRequiredType();
            }

            if ( $argument->hasOptionalTypes() )
            {
                foreach ( $argument->getOptionalTypes() as $type )
                {
                    $types[] = (string) $type;
                }
            }

            $definition[] = '$'. $argument->getName();

            if ( $argument->hasDefaultValue() )
            {
                $definition[] = '=';
                $definition[] = (string) $argument->getDefaultValue();
            }

            $phpdoc->addKeywordParam($argument->getName(), join('|', $types), join(' ', $argument->getDescription()));

            $list[] = join(' ', $definition);
        }

        if ( $function->hasReturnTypes() )
        {
            $types = [];

            foreach ( $function->getReturnTypes() as $type )
            {
                $types[] = (string) $type;
            }

            $phpdoc->addKeywordReturn(join('|', $types));
        }

        if ( $phpdoc->hasContents() && $this->getOption('function.phpdoc') )
        {
            foreach ( $phpdoc->toArray() as $line )
            {
                $result[] = $this->indent . $line;
            }
        }

        $definition   = [];
        $definition[] = $function->getAccessType();

        if ( $function->isStatic() )
        {
            $definition[] = 'static';
        }

        $definition[] = 'function';
        $definition[] = $function->getName();

        $result[] = $this->indent . sprintf('%s(%s)', join(' ', $definition), join(', ', $list));
        $result[] = $this->indent . '{';

        foreach ( $function->getBodyLines() as $line )
        {
            $result[] = $this->indent . $this->indent . $line;
        }

        $result[] = $this->indent . '}';

        return join(PHP_EOL, $result);
    }
}

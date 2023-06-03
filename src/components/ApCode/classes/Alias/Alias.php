<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Alias;

class Alias implements AliasInterface
{
    private $aliases   = [];
    private $regexp    = NULL;
    private $forbidden = [];

    /**
     * {@inheritDoc}
     * @see \ApCode\Alias\AliasInterface::set()
     */
    public function set($alias, $value)
    {
        if (isset($this->regexp)) {
            $this->regexp = null;
        }

        $this->aliases[$alias] = $value;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Alias\AliasInterface::append()
     */
    public function append($alias, $value)
    {
        if ($this->has($alias)) {
            $this->aliases[$alias] .= $value;
        }
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Alias\AliasInterface::get()
     */
    public function get($alias)
    {
        return $this->has($alias) ? $this->aliases[$alias] : NULL;

    }
    /**
     * {@inheritDoc}
     * @see \ApCode\Alias\AliasInterface::has()
     */
    public function has($alias)
    {
        return isset($this->aliases[$alias]);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Alias\AliasInterface::expand()
     */
    public function expand($string)
    {
        if (!isset($this->regexp)) {
            $this->buildRegexp();
        }

        return preg_replace_callback($this->regexp, function($row) {
            return $this->expandAlias(strtr($row[0], ['{' => '', '}' => '']));
        }, $string);
    }

    private function buildRegexp()
    {
        uksort($this->aliases, function($a, $b) { return strlen($b) - strlen($a); });

        $list = [];

        foreach ($this->aliases as $alias => $value) {
            $list[] = '{?'. addcslashes(preg_quote($alias), '~') .'}?';
        }

        $this->regexp = '~'. join('|', $list) .'~';
    }

    private function expandAlias($alias)
    {
        if (!$this->has($alias)) {
            return null;
        }

        if (isset($this->forbidden[$alias])) {
            trigger_error(sprintf('Recursive alias detected "%s"', $alias), E_USER_ERROR);
        }

        $this->forbidden[$alias] = true;

        $result = preg_replace_callback($this->regexp, function($row) {
            return $this->expandAlias(strtr($row[0], ['{' => '', '}' => '']));
        }, $this->get($alias));

        unset($this->forbidden[$alias]);

        return $result;
    }
}

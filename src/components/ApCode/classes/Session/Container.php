<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Session;

class Container implements \ArrayAccess
{
    private $name;
    private $prefix;
    private $session;

    public function __construct($name, Session $session)
    {
        $this->name    = $name;
        $this->prefix  = rtrim($name, '.') .'.';
        $this->session = $session;
    }

    public function toArray()
    {
        return $this->session->get($this->prefix);
    }

    /**
     * {@inheritDoc}
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset): bool
    {
        return $this->session->has($this->prefix . $offset);
    }

    /**
     * {@inheritDoc}
     * @see ArrayAccess::offsetGet()
     */
    public function &offsetGet($offset)
    {
        $result = null;
        $params = array_merge(explode('.', $this->name), [$offset]);

        eval('$result = &$_SESSION["'. join('"]["', $params) .'"];');

        return $result;
    }

    /**
     * {@inheritDoc}
     * @see ArrayAccess::offsetSet()
     */
    public function offsetSet($offset, $value): void
    {
        $this->session->set($this->prefix . $offset, $value);
    }

    /**
     * {@inheritDoc}
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset): void
    {
        $this->session->remove($this->prefix . $offset);
    }

    public function container($name)
    {
        return new Container($this->prefix . $name, $this->session);
    }
}

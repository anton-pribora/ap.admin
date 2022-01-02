<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Session;

class Session
{
    private $started;

    public function append($path, $value)
    {
        if ($this->has($path)) {
            $params = explode('.', $path);
            eval('$_SESSION["'. join('"]["', $params) .'"][] = $value;');
        } else {
            $this->set($path, [$value]);
        }
    }

    public function pop($path, $default = null)
    {
        $value = $this->get($path, $default);
        $this->remove($path);
        return $value;
    }

    public function get($path, $default = null)
    {
        $params = explode('.', $path);
        return eval('return isset($_SESSION) && isset($_SESSION["'. join('"]["', $params) .'"]) ? $_SESSION["'. join('"]["', $params) .'"] : $default;');
    }

    public function set($path, $value)
    {
        if (!$this->id()) {
            throw new \Exception('Please start session before use it!');
        }

        $params = explode('.', $path);
        eval('$_SESSION["'. join('"]["', $params) .'"] = $value;');
    }

    public function has($path)
    {
        $params = explode('.', $path);
        return eval('return isset($_SESSION) && isset($_SESSION["'. join('"]["', $params) .'"]);');
    }

    public function remove($path)
    {
        $params = explode('.', $path);
        eval('if (isset($_SESSION)) {unset($_SESSION["'. join('"]["', $params) .'"]);}');
    }

    public function start($id = NULL)
    {
        if ($id) {
            session_id($id);
        }

        if ($this->started) {
            return true;
        }

        $this->started = true;

        return session_start();
    }

    public function id()
    {
        return session_id();
    }

    public function destroy()
    {
        return session_destroy();
    }

    public function clear()
    {
        $_SESSION = [];
    }
}

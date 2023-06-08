<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Web\Request;

use ApCode\Web\RequestInterface;

class Http implements RequestInterface
{
    private $action;

    public function id()
    {
        if (empty($_SERVER['REQUEST_ID'])) {
            $_SERVER['REQUEST_ID'] = uniqid('req');
        }

        return $_SERVER['REQUEST_ID'];
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Web\RequestInterface::setAction()
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Web\RequestInterface::matchAction()
     */
    public function matchAction($path)
    {
        return strncmp($this->action(), $path, strlen($path)) === 0;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Web\RequestInterface::action()
     */
    public function action()
    {
        if (is_null($this->action)) {
            if (isset($_SERVER['REDIRECT_URL'])) {
                $this->action = $_SERVER['REDIRECT_URL'];
        	} else {
                $this->action = $_SERVER['SCRIPT_NAME'];
            }
        }

        $scriptName = $this->action;

        if (!preg_match('~\.[^\./]+$~', $scriptName)) {
            $scriptName = rtrim($scriptName, '/') .'/index.php';
        }

        return $scriptName;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Web\RequestInterface::method()
     */
    public function method()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function isGet()
    {
        return $this->method() == 'GET';
    }

    public function isPost()
    {
        return $this->method() == 'POST';
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Web\RequestInterface::hasVar()
     */
    public function has($varname)
    {
        if (strpos($varname, '.') > -1) {
            $idx = strtr($varname, ['.' => "']['"]);
            return eval("return isset(\$_REQUEST['$idx']);");
        }

        return isset($_REQUEST[$varname]);
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Web\RequestInterface::get()
     */
    public function get($varname, $default = null)
    {
        if (strpos($varname, '.') > -1) {
            $idx = strtr($varname, ['.' => "']['"]);
            return eval("return \$_REQUEST['$idx'] ?? \$default;");
        }

        return $_REQUEST[$varname] ?? $default;
    }

    public function getPostVariables()
    {
        return $_POST;
    }

    /**
     * {@inheritDoc}
     * @see \ApCode\Web\RequestInterface::set()
     */
    public function set($varname, $value)
    {
        $_REQUEST[$varname] = $value;
        return $this;
    }

    public function documentUri()
    {
        return $_SERVER['DOCUMENT_URI'];
    }

    public function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function ip()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function fullUri()
    {
        $https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on';
        $port  = $_SERVER['SERVER_PORT'];
        $host  = $_SERVER['HTTP_HOST'];

        $uri[] = $https ? 'https' : 'http';
        $uri[] = '://';
        $uri[] = $_SERVER['HTTP_HOST'];

        if (str_contains($host, ':')) {
            // Хост содержит информацию по порту
        } elseif ($https && $port == '443') {
            // Стандартный порт для HTTPS
        } elseif (!$https && $port == '80') {
            // Стандартный порт для HTTP
        } else {
            $uri[] = ':';
            $uri[] = $port;
        }

        if ($_SERVER['REQUEST_URI'] != '/') {
            $uri[] = $_SERVER['REQUEST_URI'];
        }

        return join($uri);
    }

    public function contentType()
    {
        return $_SERVER['CONTENT_TYPE'] ?? '';
    }

    public function isJson()
    {
        return strtolower($this->contentType()) === 'application/json';
    }

    public function readJson()
    {
        return json_decode_array(file_get_contents('php://input'));
    }

    public function isAcceptJson()
    {
        return (bool) preg_match('/json/ui', $_SERVER['HTTP_ACCEPT'] ?? '');
    }
}

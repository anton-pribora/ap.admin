<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\Web;

class Url implements \JsonSerializable
{
    private $scheme   = null;
    private $host     = null;
    private $user     = null;
    private $pass     = null;
    private $port     = null;
    private $path     = null;
    private $fragment = null;

    private $queryParams = [];

    public function __construct($url, Url $base = null)
    {
        $info = parse_url(trim($url));

        $this->scheme   = isset($info['scheme'  ]) ? strtolower($info['scheme']) : ($base ? $base->getScheme() : null);
        $this->host     = isset($info['host'    ]) ? $this->decodeHost($info['host']) : ($base ? $base->getHost() : null);
        $this->port     = isset($info['port'    ]) ? urldecode($info['port'    ]) : (isset($info['host']) ? null : ($base ? $base->getPort() : null));
        $this->user     = isset($info['user'    ]) ? urldecode($info['user'    ]) : (isset($info['host']) ? null : ($base ? $base->getUser() : null));
        $this->pass     = isset($info['pass'    ]) ? urldecode($info['pass'    ]) : (isset($info['host']) ? null : ($base ? $base->getPass() : null));
        $this->fragment = isset($info['fragment']) ? urldecode($info['fragment']) : null;

        if (isset($info['query'])) {
            $this->setQuery($info['query']);
        }

        $this->host = $this->decodeHost($this->host);

        if ( !empty($info['path']) ) {
            $path = urldecode($info['path']);

            if ( $path[0] == '/' ) {
                $this->path = $this->clearPath($path);
            } elseif ($base && $base->getPath()) {
                $basePath = $base->getPath();

                if (substr($basePath, -1, 1) == '/') {
                    $this->path = $this->clearPath($basePath . $path);
                } else {
                    $basePath = dirname($basePath);

                    if ( $basePath == '.' ) {
                        $basePath = '';
                    }

                    $this->path = $this->clearPath($basePath .'/'. $path);
                }
            } else {
                $this->path = $this->clearPath($path);
            }
        } elseif ( empty($info['host']) ) {
            $this->path = $base ? $base->getPath() : null;
        } else {
            $this->path = '/';
        }
    }

    private function decodeHost($host)
    {
        return mb_strtolower((string) $host);
    }

    private function encodeHost($host)
    {
        return $host;
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function hasQueryParam($name)
    {
        return isset($this->queryParams[$name]);
    }

    public function setQuery($query)
    {
        $this->queryParams = [];
        parse_str($query, $this->queryParams);
        return $this;
    }

    public function setQueryParams($params)
    {
        $this->queryParams = $params;
        return $this;
    }

    public function addQueryParams($params)
    {
        $this->queryParams = array_merge($this->queryParams, $params);
        return $this;
    }

    public function setQueryParam($name, $value)
    {
        if (isset($value)) {
            $this->queryParams[$name] = $value;
        } else {
            unset($this->queryParams[$name]);
        }
        return $this;
    }

    public function getQuery()
    {
        return http_build_query($this->queryParams);
    }

    public function getQueryParam($name)
    {
        return isset($this->queryParams[$name]) ? $this->queryParams[$name] : null;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function removeQueryParams()
    {
        $this->queryParams = [];
        return $this;
    }

    public function removeQueryParam($name)
    {
        unset($this->queryParams[$name]);
        return $this;
    }

    public function getFragment()
    {
        return $this->fragment;
    }

    public function removeFragment()
    {
        $this->fragment = null;
        return $this;
    }

    public function isFull()
    {
        return !empty($this->scheme);
    }

    public function isHttp()
    {
        return $this->scheme == 'http' || $this->scheme == 'https';
    }

    public function isSubUrlFor(Url $parentUrl)
    {
        if ( $this->host == $parentUrl->host ) {
            return strpos($this->path, $parentUrl->getPath()) === 0;
        }

        return false;
    }

    private function clearPath($path)
    {
        $result = [];

        foreach (explode('/', $path) as $item) {
            switch ($item) {
                case '.':
                    break;
                case '..':
                    array_pop($result);
                    $result[] = '';
                    break;

                default:
                    $result[] = $item;
                    break;
            }
        }

        $result = join('/', $result);

        return preg_replace('~/{2,}~', '/', $result);
    }

    public function asText()
    {
        return $this->toString(false);
    }

    public function asUri(): string
    {
        return $this->toString(true);
    }

    public function __toString(): string
    {
        return $this->asUri();
    }

    private function toString($asURI = false): string
    {
        $result = [];

        $encodePath = function($data) {
            return preg_replace_callback('~[^\w/\~@()\.;:"\'-]+~', function($arr){
                return rawurlencode($arr[0]);
            }, $data);
        };

        if ( $this->host ) {
            if ( $this->scheme ) {
                $result[] = $this->scheme .':';
            }

            $result[] = '//';

            if ( isset($this->user) ) {
                $result[] = $asURI ? rawurlencode($this->user) : $this->user;

                if ( isset($this->pass) ) {
                    $result[] = ':'. ($asURI ? rawurlencode($this->pass) : $this->pass);
                }

                $result[] = '@';
            }

            $result[] = $asURI ? $this->encodeHost($this->host) : $this->host;

            if ( isset($this->port) ) {
                $result[] = ':'. $this->port;
            }
        }

        if ( isset($this->path) ) {
            $result[] = $asURI ? $encodePath($this->path) : $this->path;
        }

        if ( $this->queryParams ) {
            $params = http_build_query($this->queryParams);

            if ($params) {
                $result[] = '?'. ($asURI ? $params : urldecode($params));
            }
        }

        if ( isset($this->fragment) ) {
            $result[] = '#'. ($asURI ? urlencode($this->fragment) : $this->fragment);
        }

        return join($result);
    }

    public function __debugInfo()
    {
        return ['url' => (string) $this];
    }

    /**
     * {@inheritDoc}
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize(): string
    {
        return $this->asUri();
    }
}

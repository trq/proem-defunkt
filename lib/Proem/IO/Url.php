<?php
/**

The MIT License

Copyright (c) 2010 - 2011 Tony R Quilkey <thorpe@thorpesystems.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

 */

/**
 * @category   Proem
 * @package    Proem\IO\Url
 */

/**
 * @namespace
 */
namespace Proem\IO;

/**
 * @category   Proem
 * @package    Proem\IO\Url
 */
class Url
{
    /**
     * Store our url fragments.
     *
     * @var array
     */
    private $_parsedUrl = array(
        'scheme'    => 'http',
        'host'      => '',
        'port'      => '',
        'user'      => '',
        'pass'      => '',
        'path'      => '',
        'query'     => '',
        'fragment'  => ''
    );

    /**
     * The original url string.
     *
     * @var string
     */
    private $_urlString;

    /**
     * Store our base url.
     *
     * @var string
     */
    private $_baseUrl = '';

    /**
     * Stash any odd parameters left over.
     *
     * @var string|int
     */
    private $_stash;

    /**
     * Save a cached version of our associative representation
     * of the url.
     */
    private $_urlAsAssoc = array();

    /**
     * Create our Url object from a given string representation.
     *
     * @return void
     */
    public function __construct($url = null)
    {
        if ($url !== null) {
            /**
             * A regex is required to validate the format
             * of this $url string. Failure to do so could
             * end up with errors being generated via parse_url().
             */
            $this->_urlString = $url;
        }
        $this->_parsedUrl = parse_url($url);
    }

    /**
     * Store the scheme
     *
     * @var string
     */
    public function setScheme($scheme)
    {
        $this->_parsedUrl['scheme'] = $scheme;
        return $this;
    }

    /**
     * Retrieve the url scheme
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->_parsedUrl['scheme'];
    }

    /**
     * Store the host portion of the url.
     *
     * @var string
     */
    public function setHost($host)
    {
        $this->_parsedUrl['host'] = $host;
        return $this;
    }

    /**
     * Retrieve the host portion of the url.
     *
     * @return string
    */
    public function getHost()
    {
        return $this->_parsedUrl['host'];
    }

    /**
     * Store the port portion of the url.
     *
     * @var string
     */
    public function setPort($port)
    {
        $this->_parsedUrl['port'] = $port;
        return $this;
    }

    /**
     * Retrieve the port portion of the url.
     *
     * @return string
    */
    public function getPort()
    {
        return $this->_parsedUrl['port'];
    }

    /**
     * Store the user portion of the url.
     *
     * @var string
     */
    public function setUser($user)
    {
        $this->_parsedUrl['user'] = $user;
        return $this;
    }

    /**
     * Retrieve the user portion of the url.
     *
     * @return string
     */
    public function getUser()
    {
        return $this->_parsedUrl['user'];
    }

    /**
     * Store the passowrd portion of the url.
     *
     * @var string
     */
    public function setPass($pass)
    {
        $this->_parsedUrl['pass'] = $pass;
        return $this;
    }

    /**
     * Retrieve the password portion of the url.
     *
     * @return string
     */
    public function getPass()
    {
        return $this->_parsedUrl['pass'];
    }

    /**
     * Store the path portion of the url.
     *
     * @var string
     */
    public function setPath($path)
    {
        $this->_parsedUrl['path'] = $path;
    }

    /**
     * Retrieve the path portion of the url
     *
     * @return string
     */
    public function getPath()
    {
        return $this->_parsedUrl['path'];
    }

    /**
     * Store the query portion of the url.
     * This is the part after the ?
     *
     * @var string
     */
    public function setQuery($query)
    {
        $this->_parsedUrl['query'] = $query;
    }

    /**
     * Retrieve the query portion of the url.
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->_parsedUrl['query'];
    }

    /**
     * Store the fragment portion of the url.
     * The part after any hash #
     *
     * @var string
     */
    public function setFragment($fragment)
    {
        $this->_parsedUrl['fragment'] = $fragment;
    }

    /**
     * Retrieve the fragment portion of the url.
     *
     * @return string
     */
    public function getFragment()
    {
        return $this->_parsedUrl['fragment'];
    }

    /**
     * Set the base url, this will be trimmed from all returned paths.
     *
     * @return \Proem\IO\Url
     */
    public function setBaseUrl($base)
    {
        $this->_baseUrl = $base;
        return $this;
    }

    /**
     * Retrieve the base url.
     *
     * @return string|array
     */
    public function getBaseUrl($array = false)
    {
        if (!$array) {
            return $this->_baseUrl;
        } else {
            return explode('/', trim($this->_baseUrl, '/'));
        }
    }

    /**
     * Get the path portion of the url as an associative array
     * of key => value pairs.
     *
     * By default, this function strips the baseUrl from the returned array.
     *
     * @param bool $strip Wether or not to strip the base url from the returned value.
     * @return array
     */
    public function getPathAsAssoc($strip = true, $rebuild = false)
    {
        $tmp = array();
        $base = $this->getBaseurl(true);
        $params = $this->getPathAsArray();

        if ($strip) {
            foreach ($base as $token) {
                if ($params[0] == $token) {
                    array_shift($params);
                }
            }
        }

        if (empty($this->_urlAsAssoc) || $rebuild) {
            for ($i = 0; $i <= count($params); $i = $i+2) {
                if (isset($params[$i+1])) {
                    $this->_urlAsAssoc[(string) $params[$i]] = (string) $params[$i+1];
                } else {
                    if (isset($params[$i])) {
                        $this->_stash = (string) $params[$i];
                    }
                    break;
                }
            }
        }
        return $this->_urlAsAssoc;
    }

    public function getStash()
    {
        if ($this->_stash == null) {
            $this->getPathAsAssoc();
        }
        return $this->_stash;
    }

    /**
     * Retrieve the original url as a string.
     *
     * @return string
     */
    public function getAsString()
    {
        if ($this->_urlString == null) {
            // build the string from our parsedUrl array.
        }
        return $this->_urlString;
    }

    /**
     * Break the part fragment of the url into an array.
     *
     * @return array
     */
    public function getPathAsArray()
    {
        return explode('/', trim(str_replace($this->getBaseUrl(), '', $this->getPath()), '/'));
    }
}

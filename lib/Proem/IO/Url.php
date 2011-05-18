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
    private $_parsedUrl;

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
     * Create our Url object from a given string representation.
     *
     * @return void
     */
    public function __construct($url = null)
    {
        if ($url === null) {
            // get uri from $_SERVER
        } else {

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
     * Set the base url, this will be trimmed from all returned paths.
     *
     * @return \Proem\IO\Url
     */
    public function setBaseUrl($base) {
        $this->_baseUrl = $base;
        return $this;
    }

    /**
     * Retrieve the base url.
     *
     * @return string|array
     */
    public function getBaseUrl($array = false) {
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
    public function getPathAsAssoc($strip = true)
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

        for ($i = 0; $i <= count($params); $i = $i+2) {
            if (isset($params[$i+1])) {
                $tmp[(string) $params[$i]] = (string) $params[$i+1];
            } else {
                break;
            }
        }
        return $tmp;
    }

    /**
     * Retrieve the original url as a string.
     *
     * @return string
     */
    public function getAsString()
    {
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

    /**
     * Magic __call method used to retrieve the contents of the internal
     * $_parsedUrl array as created via parse_url().
     *
     * @link http://php.net/parse_url
     * @return string|int
     */
    public function __call($method, $args)
    {
        if (substr($method, 0, 3) == 'get') {
            $method = substr($method, 3);
        }
        $method = strtolower($method);
        if (array_key_exists($method, $this->_parsedUrl)) {
            return $this->_parsedUrl[$method];
        }
        return false;
    }

}

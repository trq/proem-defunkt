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
     * Once a path has been converted into an associative
     * array of key value pairs, it is stored here.
     *
     * @var array
     */
    private $_assocPath = null;

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
     * Do the work of actually creating an associative array
     * from a numerically indexed array.
     *
     * This functionality is basically duplicated within
     * \Proem\Dispatcher\Route\AbstractRoute
     * This replication should be fixed.
     *
     * @return void
     */
    private function _setAssocPath()
    {
        $tmp = array();
        $params = $this->getPathAsArray();
        for ($i = 0; $i <= count($params); $i = $i+2) {
            if (isset($params[$i+1])) {
                $tmp[(string) $params[$i]] = (string) $params[$i+1];
            } else {
                break;
            }
        }
        $this->_assocPath = $tmp;
        return $this;
    }

    /**
     * Retrieve the original url as a string.
     *
     * @return string
     */
    public function getString()
    {
        return $this->_urlString;
    }

    /**
     * Get the path portion of the url as an associative array
     * of key => value pairs.
     *
     * @return array
     */
    public function getPathAsAssoc()
    {
        if ($this->_assocPath === null) {
            $this->_setAssocPath();
        }
        return $this->_assocPath;
    }

    /**
     * Break the part fragment of the url into an array.
     *
     * @return array
     */
    public function getPathAsArray()
    {
        return explode('/', trim($this->getPath(), '/'));
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

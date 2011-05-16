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
    /*
     *  Array
     *  (
     *      [scheme] => http
     *      [host] => hostname
     *      [user] => username
     *      [pass] => password
     *      [path] => /path
     *      [query] => arg=value
     *      [fragment] => anchor
     *  )
     *
     */
    private $_parsedUrl;

    private $_urlString;

    private $_assocPath = null;

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

    public function getString()
    {
        return $this->_urlString;
    }

    public function getPathAsAssoc()
    {
        if ($this->_assocPath === null) {
            $this->_setAssocPath();
        }
        return $this->_assocPath;
    }

    /*
     * This functionality is basically duplicated within
     * \Proem\Dispatcher\Route\AbstractRoute
     * This replication should be fixed.
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

    public function getPathAsArray()
    {
        return explode('/', trim($this->_parsedUrl['path'], '/'));
    }

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

<?php
/**
 
The MIT License

Copyright (c) 2010 - 2011 Tony R Quilkey <trq@proemframework.org>

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
 * @package    Proem\IO\Response
 */

/**
 * @namespace
 */
namespace Proem\IO;

/**
 * @category   Proem
 * @package    Proem\IO\Response
 */
class Response
{
    /**
     * Store the body of the response.
     *
     * @var string
     */
    protected $_body;

    /**
     * Set the reponse body.
     *
     * @param string $data
     * @return Proem\IO\Response\AbstractResponse
     */
    public function setBody($data)
    {
        $this->_body = $data;
        return $this;
    }

    /**
     * Get the response body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * Send response to the browser.
     */
    public function send()
    {
        echo $this->_body;
    }

    /**
     * Magic __toString functionality
     *
     * Proxies to {@link send()} and returns response value as string
     * using output buffering.
     *
     * @return string
     */
    public function __toString()
    {
        ob_start();
        $this->send();
        return ob_get_clean();
    }
}

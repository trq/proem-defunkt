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
 * @package    Proem\Application
 */

/**
 * @namespace
 */
namespace Proem;

/**
 * The heart of a proem Application. The Proem\Application object is responsible
 * for storing:
 * - The Chain and any resources that Chain Event's might create.
 * - The request and Response objects.
 *
 * @category   Proem
 * @package    Proem\Application
 */
class Application
{
    /**
     * Store any resources.
     *
     * @var array
     */
    private $_resources = array();

    /**
     * Store the Chain.
     *
     * @var Proem\Chain\AbstractChain
     */
    private $_chain;

    /**
     * Store the Request object.
     *
     * @var Proem\IO\AbstractRequest
     */
    private $_request;

    /**
     * Store the Response object.
     *
     * @var Proem\IO\AbstractResponse
     */
    private $_response;

    /**
     * Create a Chain object once instantiated.
     */
    public function __construct()
    {
        $this->setChain(new Chain($this));
    }

    /**
     * Set or override the Chain object.
     *
     * @param Chain\AbstractChain $chain
     * @return Proem\Application
     */
    public function setChain(Chain $chain)
    {
        $this->_chain = $chain;
        return $this;
    }

    /**
     * Retrieve the Chain object.
     *
     * @return Proem\Chain\ChainAbstract
     */
    public function getChain()
    {
        return $this->_chain;
    }

    /**
     * Set the Request object.
     *
     * @param IO\AbstractRequest $request
     * @return Proem\Application
     */
    public function setRequest(IO\AbstractRequest $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * Retrieve the Request object.
     *
     * @return Proem\IO\AbstractRequest
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Set the Response object.
     *
     * @param IO\AbstractResponse $response
     * @return Proem\Application
     */
    public function setResponse(IO\AbstractResponse $response)
    {
	    $this->_response = $response;
        return $this;
    }

    /**
     * Retrieve the Response object.
     *
     * @return Proem\IO\AbstractResponse
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Store a resource.
     *
     * @param string $name name of resource to store.
     * @param mixed $item
     * @return Proem\Application
     */
    public function setResource($name, $item)
    {
	    $this->_resources[$name] = $item;
        return $this;
    }

    /**
     * Retrieve a Resource by name.
     *
     * @param string $name Name of resource to retrieve.
     * @return mixed
     */
    public function getResource($name)
    {
        if (isset($this->_resources[$name])) {
            return $this->_resources[$name];
        }
        return false;
    }

}

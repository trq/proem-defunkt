<?php

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
     * Store an instance.
     *
     * @var Proem\Application
     */
    private static $_instance = null;

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
    public function setChain(Chain\AbstractChain $chain)
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
     * A simple proxy through to the Chain's run() method.
     *
     * This is really only here to make the boostrap process
     * look nice and clean.
     *
     * @return void
     */
    public function run()
    {
	$this->getChain()->run($this);
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

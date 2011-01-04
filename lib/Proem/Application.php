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
     * Retrieve an instance of Proem\Application
     *
     * @return Proem\Application
     * @todo Would like to remove this singleton asap.
     */
    public static function getInstance ()
    {
        if (is_null(self::$_instance)) {
            $class = __CLASS__;
            self::$_instance = new $class;
        }
        self::$_instance->setChain(new Chain(self));
        return self::$_instance;
    }

    /**
     * Create a Chain object once instantiated.
     *
     * @todo This should probably also go. Even though we can override this
     * object latter, I don't like it being so tightly coupled with
     * proem\Application.
     */
    private function __construct()
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
        return self::$_instance;
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
        return self::$_instance;
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
        return self::$_instance;
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
        return self::$_instance;
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

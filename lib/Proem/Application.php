<?php

namespace Proem;

class Application
{
    private static $_instance = null;

    private $_resources = array();

    private $_chain;

    private $_request;

    private $_response;

    public static function getInstance ()
    {
        if (is_null(self::$_instance)) {
            $class = __CLASS__;
            self::$_instance = new $class;
        }
        self::$_instance->setChain(new Chain(self));
        return self::$_instance;
    }

    private function __construct()
    {
        $this->setChain(new Chain($this));
    }

    public function setChain(Chain\AbstractChain $chain)
    {
        $this->_chain = $chain;
        return self::$_instance;
    }

    public function getChain()
    {
        return $this->_chain;
    }

    public function setRequest(IO\AbstractRequest $request)
    {
        $this->_request = $request;
        return self::$_instance;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function setResponse(IO\AbstractResponse $response)
    {
        $this->_request = $response;
        return self::$_instance;
    }

    public function getResponse()
    {
        return $this->_response;
    }

    public function setResource($name, $item)
    {
        $this->_resources[$name] = $item;
        return self::$_instance;
    }

    public function getResource($name)
    {
        if (isset($this->_resources[$name])) {
            return $this->_resources[$name];
        }
        return false;
    }

}
<?php

namespace Proem;

class Application
{
    private $_resources = array();

    private $_chain;

    private $_request;

    private $_response;

    public function __construct()
    {
        $this->setChain(new Event\Chain);
    }

    public function setChain(Event\ChainAbstract $chain)
    {
        $this->_chain = $chain;
    }

    public function getChain()
    {
        return $this->_chain;
    }

    public function setRequest(IO\RequestAbstract $request)
    {
        $this->_request = $request;
        return $this;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function setResponse(IO\ResponseAbstract $response)
    {
        $this->_request = $response;
        return $this;
    }

    public function getResponse()
    {
        return $this->_response;
    }

    public function setResource($name, $item)
    {
        $this->_resources[$name] = $item;
        return $this;
    }

    public function getResource($name)
    {
        if (isset($this->_resources[$name])) {
            return $this->_resources[$name];
        }
        return false;
    }

}
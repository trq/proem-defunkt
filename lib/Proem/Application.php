<?php

namespace Proem;

class Application
{
    private $_resources = array();

    private $_chain;

    public function __construct(Event\Chain $chain)
    {
        $this->_chain = $chain;
    }

    public function getChain()
    {
        return $this->_chain;
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

    public function run()
    {
        $this->getChain()->run();
        return $this;
    }

}
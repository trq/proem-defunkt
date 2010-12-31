<?php

namespace Proem\Chain;

abstract class ChainAbstract
{
    protected $_events = array();

    public function registerEvent($event, Event\EventAbstract $object) {
        $this->_events[$event] = $object;
        return $this;
    }

    public function registerEvents(Array $events) {
        foreach ($events as $event => $object) {
            $this->registerEvent($event, $object);
        }
        return $this;
    }

    public function getEvents()
    {
        return $this->_events;
    }

    public function getInitialEvent()
    {
        return reset($this->_events);
    }

    public function getNextEvent()
    {
        return next($this->_events);
    }

    public abstract function run();
}
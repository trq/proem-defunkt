<?php

namespace Proem\Chain\Event;

abstract class AbstractEvent
{
    public abstract function in();

    public abstract function out();

    final function run(\Proem\Chain $chain)
    {
        $this->in();
        $event = $chain->getNextEvent();
        if ($event) {
            $event->run($chain);
        }
        $this->out();
        return $this;
    }

}
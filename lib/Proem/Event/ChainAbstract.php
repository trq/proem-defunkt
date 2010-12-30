<?php

namespace Proem\Event;

abstract class ChainAbstract
{
    protected $_events = array();

    protected function registerEvent($event, $object, $params = array()) {
        $this->_events[] = array(
            'Event' => $event,
            'Object' => $object,
            'Params' => $params
        );
    }

    protected function registerEvents(Array $events) {
        foreach ($events as $event => $detail) {
            $this->registerEvent(
                $detail['Event'],
                $detail['Object'],
                $detail['Params']
            );
        }
    }

    abstract public function run();
}
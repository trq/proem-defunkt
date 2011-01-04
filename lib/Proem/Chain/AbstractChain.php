<?php

/**
 * @category   Proem
 * @package    Proem\Chain\AbstractChain
 */

/**
* @namespace
*/
namespace Proem\Chain;

/**
 * An Abstract Chain interface. extend this class to create a Chain
 * responsible for storing, locating and executing Chain Events.
 * 
 * @category   Proem
 * @package    Proem\Chain\AbstractChain
 */
abstract class AbstractChain
{
    /**
     * Store the Chain Event objects in an associative array.
     *
     * @var array
     */
    protected $_events = array();

    /**
     * Register a single Event.
     *
     * @param string $event
     * @param Event\AbstractEvent $object
     * @return AbstractChain
     */
    public function registerEvent($event, Event\AbstractEvent $object) {
        $this->_events[$event] = $object;
        return $this;
    }

    /**
     * Register multiple events at once.
     *
     * @param array $events
     * @return AbstractChain
     */
    public function registerEvents(Array $events) {
        foreach ($events as $event => $object) {
            $this->registerEvent($event, $object);
        }
        return $this;
    }

    /**
     * Retrieve all the events currently in the Chain.
     *
     * @return array
     */
    public function getEvents()
    {
        return $this->_events;
    }

    /**
     * retrieve the first event in the Chain.
     *
     * @return array
     */
    public function getInitialEvent()
    {
        return reset($this->_events);
    }

    /**
     * Move the internal pointer to the next event in the Chain and return it.
     *
     * @return array
     */
    public function getNextEvent()
    {
        return next($this->_events);
    }

    /**
     * Start the Chain in motion.
     */
    public abstract function run();
}
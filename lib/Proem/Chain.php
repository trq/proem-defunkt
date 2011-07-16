<?php
/**

The MIT License

Copyright (c) 2010 - 2011 Tony R Quilkey <thorpe@thorpesystems.com>

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
 * @package    Proem\Chain\AbstractChain
 */

/**
 * @namespace
 */
namespace Proem;

/**
 * The Proem Boostrap Event Chain.
 *
 * Responsible for storing, locating and executing Chain Events.
 *
 * @category   Proem
 * @package    Proem
 */
class Chain
{
    /**
     * Store the Chain Event objects in an associative array.
     *
     * @var array
     */
    protected $_events = array();

    /**
     * Store an instance of the \Proem\Application object.
     *
     * @var \Proem\Application
     */
    protected $_application;

    /**
     * Ensure that a \Proem\Application is passed into the Chain.
     *
     * @return void
     */
    public function __construct(\Proem\Application $application)
    {
        $this->_application = $application;
    }

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
        $this->_events = array_merge($this->_events, $events);
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
     * Inject more events into a specific location within the event chain.
     *
     * By default this will inject the events after the $key provided. Supplying
     * true as the $before argument will place the new events before the suplied $key.
     *
     * @param array $events
     * @param string $key
     * @param bool $before
     * @return \Proem\Chain
     */
    public function injectEvents(Array $events, $key, $before = false) {
        $index = array_search($key, array_keys($this->_events));
        if ($index === FALSE){
            $index = count($this->_events);
        } else {
            if (!$before) {
                $index++;
            }
        }
        $end = array_splice($this->_events, $index);
        $this->_events = array_merge($this->_events, $events, $end);
        return $this;
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
     * Move the internal pointer to the previous event in the Chain and return it.
     *
     * @return array
     */
    public function getPreviousEvent()
    {
        return prev($this->_events);
    }

    /**
     * Start the Chain in motion.
     */
    public function run() {
        $event = $this->getInitialEvent();
        $event->run($this, $this->_application);
    }
}

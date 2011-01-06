<?php

/**
 * @category   Proem
 * @package    Proem\Chain\Event\AbstractEvent
 */

/**
 * @namespace
 */
namespace Proem\Chain\Event;

/**
 * @category   Proem
 * @package    Proem\Chain\Event\AbstractEvent
 *
 * An Abstract Chain Event interface. Extend this class to
 * create Chain Events.
 */
abstract class AbstractEvent
{
    /**
     * Method to be called on the way in the Chain
     */
    public abstract function in(\Proem\Application $application);

    /**
     * Method to be called on the way out of the Chain.
     */
    public abstract function out(\Proem\Application $application);

    /**
     * This method will execute in() -> the next event in the chain -> out().
     * 
     * @param \Proem\Chain $chain
     * @return AbstractEvent
     */
    final function run(\Proem\Chain $chain, \Proem\Application $application)
    {
        $this->in($application);
        $event = $chain->getNextEvent();
        if ($event) {
            $event->run($chain, $application);
        }
        $this->out($application);
        return $this;
    }

}

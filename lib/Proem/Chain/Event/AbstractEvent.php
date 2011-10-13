<?php
/**
 
The MIT License

Copyright (c) 2010 - 2011 Tony R Quilkey <trq@proemframework.org>

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

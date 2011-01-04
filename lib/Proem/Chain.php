<?php

/**
 * @category   Proem
 * @package    Proem\Chain
 */

/**
 * @namespace
 */
namespace Proem;

/**
 * A concrete Proem\Chain\AbstractChain implementation.
 *
 * @category   Proem
 * @package    Proem\Chain
 */
class Chain extends Chain\AbstractChain
{
    /**
     * Start the Chain in motion.
     */
    public function run() {
        $event = $this->getInitialEvent();
        $event->run($this);
    }
}

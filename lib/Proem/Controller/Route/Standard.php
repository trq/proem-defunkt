<?php

/**
 * @category   Proem
 * @package    Proem\Controller\Route\Standard
 */

/**
 * @namespace
 */
namespace Proem\Controller\Route;

/**
 * The standard concrete _Route_.
 *
 * Designed to be fast. This route simply takes a given url and splits it into
 * an array.
 *
 * The parts of this array are then sent to the _Command_ object setting the first
 * index to controller, the second to action and all others as params (which are
 * in turn transformed into key => value pairs).
 *
 * @category   Proem
 * @package    Proem\Controller\Route\Standard
 */
class Standard extends AbstractRoute
{
    /**
     * process the given uri.
     *
     * @param string $uri
     * @param array $options
     */
    public function process($uri, $options = array()) {
        $matches = explode('/', (string) trim($uri, '/'));
        if (is_array($matches)) {
            $this->getCommand()->setParam('controller', array_shift($matches));
            $this->getCommand()->setParam('action', array_shift($matches));
            if (count($matches)) {
                $this->getCommand()->setParam('params', $matches);
            }
            $this->setMatchFound();
            $this->getCommand()->isPopulated(true);
        }
    }
}
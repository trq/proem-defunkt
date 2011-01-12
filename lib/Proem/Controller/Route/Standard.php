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
 * The standard concrete _Route_. This _Route_ is designed to take a simple
 * pattern, translate that into a more complex regular expression, which in
 * turn is used to match against the given url to retrieve the controller /
 * action & params combinations.
 *
 * @category   Proem
 * @package    Proem\Controller\Route\Standard
 */
class Standard extends AbstractRoute
{
    public function process($uri, $options = array()) {
        $matches = explode('/', trim($uri, '/'));
        $this->setMatchFound();
        $this->getCommand()->controller = array_shift($matches);
        $this->getCommand()->action     = array_shift($matches);
        if (count($matches)) {
            $this->getCommand()->params = implode('/', $matches);
        } else {
            $this->getCommand()->params = array();
        }
    }
}
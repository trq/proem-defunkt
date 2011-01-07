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
        $pattern = '@\/([a-zA-Z0-9_\+\-%]+)*\/*([a-zA-Z0-9_\+\-%]+)*\/*([a-zA-Z0-9_\+\-%\/]+)*@';
        if (preg_match($pattern, $uri, $matches)) {
            $this->setMatchFound();
            $this->setParam('controller', $matches[1]);
            $this->setParam('action', $matches[2]);

            if (isset($matches[3])) {
                $this->setParam('params', explode('/', trim($matches[3], '/')));
            } else {
                $this->setParam('params', array());
            }
        }
    }
}
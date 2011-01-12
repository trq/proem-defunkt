<?php

/**
 * @category   Proem
 * @package    Proem\Controller\Route\Fixed
 */

/**
 * @namespace
 */
namespace Proem\Controller\Route;

/**
 * A concrete _Route_ designed to bypass routing (does that even make sense?)
 * and hand everything to a default controller / action with the original
 * url completely intact and stored within the params.
 *
 * This _Route_ type would be usefull on the front end of a CMS or system
 * designed to serve data from a datasource (db) based on the url.
 *
 * @category   Proem
 * @package    Proem\Controller\Route\Fixed
 */
class Fixed extends AbstractRoute
{
    public function process($uri, $options = array())
    {
        $this->setMatchFound();
        $this->getCommand()->controller = isset($options['controller']) ? $options['controller'] : null;
        $this->getCommand()->action     = isset($options['action']) ? $options['action'] : null;
        $this->getCommand()->params     = $uri;
    }
}
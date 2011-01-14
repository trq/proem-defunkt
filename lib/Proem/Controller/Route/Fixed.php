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
 * The _Fixed_ _Route_.
 * 
 * A concrete _Route_ designed to bypass routing (does that even make sense?)
 * and hand everything to a default controller / action with the parts of the
 * original uri sent to the _Command_ object as params.
 *
 * This _Route_ type would be usefull on the front end of a CMS or system
 * designed to serve data from a datasource (db) based on the url.
 *
 * @category   Proem
 * @package    Proem\Controller\Route\Fixed
 */
class Fixed extends AbstractRoute
{
    /**
     * Process the given uri.
     *
     * Sets the controller & action params within the _Command_ object to those
     * passed in via the $options array, then sets the *match found* flag as well
     * as the isPopulated flag on the _Command_ object.
     *
     * The entire uri is then sent to the _Command_ object as params (which are
     * in turn transformed into key => value pairs).
     *
     * @param string $uri
     * @param array $options
     */
    public function process($uri, $options = array())
    {
        $this->getCommand()->setParam('controller', isset($options['controller']) ? $options['controller'] : null);
        $this->getCommand()->setParam('action', isset($options['action']) ? $options['action'] : null);
        $this->getCommand()->setParam('params', explode('/', (string) trim($uri,'/')));
        $this->setMatchFound();
        $this->getCommand()->isPopulated(true);
    }
}
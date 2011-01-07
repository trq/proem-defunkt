<?php

/**
 * @category   Proem
 * @package    Proem\Controller\Route\Through
 */

/**
 * @namespace
 */
namespace Proem\Controller\Route;

/**
 * A concrete _Route_ designed to bypass routing (does that maike sense?)
 * and hand everything to a default controller / action with the original
 * url completely intact and stored within the params.
 *
 * This _Route_ type would be usefull on the front end of a CMS or system
 * designed to serve data from a datasource (db) based on the url.
 *
 * @category   Proem
 * @package    Proem\Controller\Route\Through
 */
class Through extends AbstractRoute
{
    public function process($uri, $options = array())
    {
        if (
            array_key_exists('controller', $options) &&
            array_key_exists('action', $options)
        ) {
            $this->setMatchFound();
            $this->setParam('controller', $options['controller']);
            $this->setParam('action', $options['action']);
            $this->setParam('params', $uri);
        } else {
            throw new \Proem\Exception(
                'Invalid options array passed to Proem\Controller\Route\Through'
            );
        }
    }
}
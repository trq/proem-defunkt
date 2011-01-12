<?php

/**
 * @category   Proem
 * @package    Proem\Controller\Route\AbstractRoute
 */

/**
 * @namespace
 */
namespace Proem\Controller\Route;

/**
 * An Abstract Route Interface.
 *
 * @category   Proem
 * @package    Proem\Controller\Route\AbstractRoute
 */
abstract class AbstractRoute
{
    /**
     * Store a flag indicating a route match
     *
     * @var bool
     */
    protected $_matched = false;

    /**
     * Store matched parameters within a Command object.
     *
     * @var Proem\Controller\Route\Command
     */
    protected $_command;

    /**
     * Setup the Command object.
     */
    public function __construct()
    {
        $this->_command = new \Proem\Controller\Command;
    }

    /**
     * Was a match found?
     *
     * @return bool
     */
    public function getMatchFound()
    {
        return $this->_matched;
    }

    /**
     * Set _matched flag.
     *
     * @return Proem\Controller\Route\AbstractRoute
     */
    public function setMatchFound($bool = true)
    {
        $this->_matched = $bool;
        return $this;
    }

    /**
     * Retrieve the Command object.
     */
    public function getCommand()
    {
        return $this->_command;
    }

    /**
     * Method to actually test for a match.
     *
     * If a match is found, $this->_matched should be set to true
     * and $this->_params needs to be set to contain the relevent
     * matched data.
     *
     * @param string $uri
     * @param array $options Options dependent on your implementation.
     */
    abstract public function process($uri, $options = array());
}
<?php

/**
 * @category   Proem
 * @package    Proem\Controller\Command\AbstractCommand
 */

/**
 * @namespace
 */
namespace Proem\Controller\Command;

/**
 * Store the controller, action and params.
 *
 * @category   Proem
 * @package    Proem\Controller\Command\AbstractCommand
 */
abstract class AbstractCommand
{
    protected $_data = array();
    public $controller = null;
    public $action = null;
    public $params = array();

    public function __set($name, $value) {
        $this->_data[$name] = $value;
    }

    public function __get($name) {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
    }

    abstract public function parseParams();
}
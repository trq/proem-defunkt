<?php

/**
 * @category   Proem
 * @package    Proem\Controller\Route\Command
 */

/**
 * @namespace
 */
namespace Proem\Controller\Route;

/**
 * Store the controller, action and params.
 *
 * @category   Proem
 * @package    Proem\Controller\Route\Command
 */
class Command
{
    private $_data = array();

    public function __set($name, $value) {
        $this->_data[$name] = $value;
    }

    public function __get($name) {
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
        return $this;
    }

    public function parseParams()
    {
        $tmp = array();
        for ($i = 0; $i <= count($this->_data['params']); $i = $i+2) {
            if (isset($this->_data['params'][$i+1])) {
                $tmp[$this->_data['params'][$i]] = $this->_data['params'][$i+1];
            } else {
                break;
            }
        }
        return $tmp;
    }
}
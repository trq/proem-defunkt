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
    public $controller = null;
    public $action = null;
    public $params = array();

    public function parseParams()
    {
        $tmp = array();
        for ($i = 0; $i <= count($this->params); $i = $i+2) {
            if (isset($this->params[$i+1])) {
                $tmp[$this->params[$i]] = $this->params[$i+1];
            } else {
                break;
            }
        }
        return $tmp;
    }
}
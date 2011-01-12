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
    public $controller;
    public $action;
    public $params;

    abstract public function parseParams();
}
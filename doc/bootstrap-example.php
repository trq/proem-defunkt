<?php

/**
 * This is just a running example of what a bootstrap file
 * might look like to get an application built on top of
 * Proem up and running.
 *
 * It's a good demo that gives me a design to work toward.
 */

/**
 * Register the autoloader
 * Assumes the Proem/lib directory is already on php's include_path
 */
Proem\Loader::getInstance()->registerAutoload();

/**
 * Instantiate the Application object
 */
$application = new Proem\Application;

/**
 * Setup the Chain.
 */
$application->getChain()->registerEvents(
    array(
	    'request'	=> new Proem\Chain\Event\setupHttpRequest,
	    'response'	=> new Proem\Chain\Event\setupHttpResponse,
	    'route'		=> new Proem\Chain\Event\setupRouter,
	    'dispatch'	=> new Proem\Chain\Event\setupDispatch
    )
)->run(); // Start the chain.

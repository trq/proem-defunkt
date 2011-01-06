<?php

/**
 * @category   Proem
 * @package    Proem\IO\Response
 */

/**
 * @namespace
 */
namespace Proem\IO;

/**
 * @category   Proem
 * @package    Proem\IO\Response
 */
class Response
{
    /**
     * Store the body of the response.
     *
     * @var string
     */
    protected $_body;

    /**
     * Set the reponse body.
     *
     * @param string $data
     * @return Proem\IO\Response\AbstractResponse
     */
    public function setBody($data)
    {
        $this->_body = $data;
        return $this;
    }

    /**
     * Get the response body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * Send response to the browser.
     */
    public function send()
    {
        echo $this->_body;
    }

    /**
     * Magic __toString functionality
     *
     * Proxies to {@link send()} and returns response value as string
     * using output buffering.
     *
     * @return string
     */
    public function __toString()
    {
        ob_start();
        $this->send();
        return ob_get_clean();
    }
}
<?php
/**

The MIT License

Copyright (c) 2010 - 2011 Tony R Quilkey <thorpe@thorpesystems.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

 */

/**
 * @category   Proem
 * @package    Proem\Dispatcher\Route\Fixed
 */

/**
 * @namespace
 */
namespace Proem\Dispatcher\Route;

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
 * @package    Proem\Dispatcher\Route\Fixed
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
        $this->getCommand()->setParams(explode('/', (string) trim($uri, '/')));
        $this->setMatchFound();
        $this->getCommand()->isPopulated(true);
    }
}

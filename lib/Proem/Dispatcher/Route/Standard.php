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
 * @package    Proem\Dispatcher\Route\Standard
 */

/**
 * @namespace
 */
namespace Proem\Dispatcher\Route;

/**
 * The standard concrete _Route_.
 *
 * Designed to be fast. This route simply takes a given url and splits it into
 * an array.
 *
 * The parts of this array are then sent to the _Command_ object setting the first
 * index to controller, the second to action and all others as params (which are
 * in turn transformed into key => value pairs).
 *
 * @category   Proem
 * @package    Proem\Dispatcher\Route\Standard
 */
class Standard extends AbstractRoute
{
    /**
     * Process the given url.
     *
     * @param \Proem\IO\Url $url
     * @param array $options
     */
    public function process(\Proem\IO\Url $url, $options = array()) {
        $matches = $url->getPathAsArray();
        $this->getCommand()->setParam('controller', array_shift($matches));
        $this->getCommand()->setParam('action', array_shift($matches));
        if (count($matches)) {
            $this->getCommand()->setParams($matches);
        }
        $this->setMatchFound();
        $this->getCommand()->isPopulated(true);
    }
}

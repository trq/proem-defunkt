<?php
/**

The MIT License

Copyright (c) 2010 - 2011 Tony R Quilkey <trq@proemframework.org>

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
 * @package    Proem\Dispatcher\Route\Map
 */

/**
 * @namespace
 */
namespace Proem\Dispatcher\Route;

/**
 * The _Map_ _Route_.
 *
 * This _Route_ is designed to take a simple pattern, translate that into a more
 * complex regular expression, which in turn is used to match against the given
 * url to retrieve the controller / action & params combinations.
 *
 * @category   Proem
 * @package    Proem\Dispatcher\Route\Map
 */
class Map extends AbstractRoute
{
    /**
     * Store default tokens..
     */
    private $_default_tokens = array();

    /**
     * Store default filters.
     */
    private $default_filters = array();

    /**
     * Instantiate object & setup default filters.
     */
    public function __construct() {
        parent::__construct();

        $this->_default_filters = array(
            ':default'  => '[a-zA-Z0-9_\+\-%]+',
            ':gobble'   => '[a-zA-Z0-9_\+\-%\/]+',
            ':year'     => '[12][0-9]{3}',
            ':month'    => '0[1-9]|1[012]',
            ':day'      => '0[1-9]|[12][0-9]|3[01]',
            ':num'      => '[0-9]+',
            ':alpha'    => '[a-zA-Z]+',
            ':slug'     => '[a-zA-Z0-9_-]+'
        );

        $this->_default_tokens = array(
            'module'     => $this->_default_filters[':default'],
            'controller' => $this->_default_filters[':default'],
            'action'     => $this->_default_filters[':default'],
            'params'     => $this->_default_filters[':gobble']
        );
    }

    /**
     * Process the gievn url.
     *
     * This route takes a simplified series of patterns such as :controller and
     * replaces them with more complex regular expressions which are then used
     * within a preg_match_callback to match against the given uri.
     *
     * A default rule of /:controller/:action/:params is used if no rule is
     * provided through the $options array.
     *
     * If a 'filter' regex is set within the $options array that regex will be
     * used within the preg_match_callback. Otherwise a default regex of
     * ([a-zA-Z0-9_\+\-%]+) is used.
     *
     * If one of the 'simplified' patterns within the rule is :params, this is
     * treated specially and uses a ([a-zA-Z0-9_\+\-%\/]+) regex which will match
     * the same as the default as well as / .
     *
     * This causes the pattern to match entire sections of uri's. Allowing a
     * simple pattern like the default /:controller/:action/:params to match
     * uri's like /foo/bar/a/b/c/d/e/f/g/h and cause everything after /foo/bar
     * to be added to the _Command_ object as params (which are in turn transformed
     * into key => value pairs).
     *
     * @param \Proem\IO\Url $url
     * @param array $options
     */
    public function process(\Proem\IO\Url $url, $options = array())
    {
        if (!isset($options['rule'])) {
            return false;
        }

        $rule            = $options['rule'];
        $target          = isset($options['target']) ? $options['target'] : array();
        $custom_filters  = isset($options['filter']) ? $options['filter'] : array();

        // Need to be saved locally so we can easily
        // pass them to the callback below.
        $default_tokens     = $this->_default_tokens;
        $default_filters    = $this->_default_filters;

        $keys = array();
        $values = array();
        $params = array();

        preg_match_all('@:([\w]+)@', $rule, $keys, PREG_PATTERN_ORDER);
        $keys = $keys[0];

        $regex = preg_replace_callback(
            '@:[\w]+@',
            function($matches) use ($custom_filters, $default_tokens, $default_filters)
            {
                $key = str_replace(':', '', $matches[0]);
                if (array_key_exists($key, $custom_filters)) {
                    if (array_key_exists($custom_filters[$key], $default_filters)) {
                        return '(' . $default_filters[$custom_filters[$key]] . ')';
                    } else {
                        return '(' . $custom_filters[$key] . ')';
                    }
                } else if (array_key_exists($key, $default_tokens)) {
                    return '(' . $default_tokens[$key] . ')';
                } else {
                    return $default_filters['default'];
                }
            },
            $rule
        ) . '/?';

        if (preg_match('@^' . $regex . '$@', $url->getPath(), $values)) {
            array_shift($values);

            foreach ($keys as $index => $value) {
                $params[substr($value, 1)] = urldecode($values[$index]);
            }

            foreach ($target as $key => $value) {
                $params[$key] = $value;
            }

            $this->setMatchFound();
            foreach ($params as $key => $value) {
                // If the string within $value looks like a / seperated string,
                // parse it into an array and send it to setParams() instead
                // of the singular setParam.
                if ($key == 'params' && strpos($value, '/') !== false) {
                    $this->getCommand()->setParams($this->createAssocArray($value));
                } else {
                    $this->getCommand()->setParam($key, $value);
                }
            }

            $this->getCommand()->isPopulated(true);
        }
    }

}

<?php

/**
 * @category   Proem
 * @package    Proem\Controller\Route\Map
 */

/**
 * @namespace
 */
namespace Proem\Controller\Route;

/**
 * The _Map_ _Route_.
 *
 * This _Route_ is designed to take a simple pattern, translate that into a more
 * complex regular expression, which in turn is used to match against the given
 * url to retrieve the controller / action & params combinations.
 *
 * @category   Proem
 * @package    Proem\Controller\Route\Map
 */
class Map extends AbstractRoute
{
    /**
     * Process the gievn uri.
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
     * @param string $uri
     * @param array $options
     */
    public function process($uri, $options = array())
    {
        // A standard rule.
        $rule = isset($options['rule']) ? $options['rule'] : '/:controller/:action/:params';
        
        $target = isset($options['target']) ? $options['target'] : array();
        $filter = isset($options['filter']) ? $options['filter'] : array();

        $keys = array();
        $values = array();
        $params = array();

        preg_match_all('@:([\w]+)@', $rule, $keys, PREG_PATTERN_ORDER);
        $keys = $keys[0];

        $regex = preg_replace_callback(
            '@:[\w]+@',
            function($matches) use ($filter)
            {
                $key = str_replace(':', '', $matches[0]);
                if (array_key_exists($key, $filter)) {
                    return '(' . $filter[$key] . ')';
                } else if ($key == 'params') {
                    return '([a-zA-Z0-9_\+\-%\/]+)';
                } else {
                    return '([a-zA-Z0-9_\+\-%]+)';
                }
            },
            $rule
        ) . '/?';

        if (preg_match('@^' . $regex . '$@', $uri, $values)) {

            array_shift($values);

            foreach ($keys as $index => $value) {
                $params[substr($value, 1)] = urldecode($values[$index]);
            }

            foreach ($target as $key => $value) {
                $params[$key] = $value;
            }

            $this->setMatchFound();
            foreach ($params as $key => $value) {
                if ($key == 'params') {
                    $this->getCommand()->setParam($key, explode('/', trim($value, '/')));
                } else {
                    $this->getCommand()->setParam($key, $value);
                }
            }

            $this->getCommand()->isPopulated(true);
        }
    }
}
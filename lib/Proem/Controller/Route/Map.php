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
 * @category   Proem
 * @package    Proem\Controller\Route\Map
 */
class Map extends AbstractRoute
{
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
                    // Allow params to contain /
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
        }

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
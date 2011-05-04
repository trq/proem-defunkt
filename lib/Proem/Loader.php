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
 * @package    Proem\Loader
 */

/**
 * @namespace
 */
namespace Proem;

/**
 * @category   Proem
 * @package    Proem\Loader
 *
 * A simple spl_autoload wrapper.
 * @link http://php.net/spl_autoload
 */
class Loader
{
    /**
     * Store an instance.
     *
     * @var Proem\Loader
     */
    private static $_instance;

    /**
     * Prevent instantiation.
     */
    private function __construct()
    {
    }

    /**
     * Get an instance.
     *
     * @return Proem\Loader
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * If the class doesn't already exist, attempt to 'require' it.
     *
     * @param string $class
     * @return Proem\Loader
     */
    public static function load($class)
    {
        if (!class_exists($class, false)) {
            $class = ltrim($class, '\\_');
            require_once str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $class) . '.php';
        }
        return self::$_instance;
    }

    /**
     * Add a path to the include_path
     *
     * @param string $path
     * @return Proem\Loader
     */
    public function addPath($path)
    {
        $incpath = explode(PATH_SEPARATOR, get_include_path());
        if (!in_array($path, $incpath) && file_exists($path)) {
            set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        }
        return self::$_instance;
    }

    /**
     * Register the autoload function.
     *
     * @return bool
     */
    public function registerAutoload()
    {
        return spl_autoload_register(array('Proem\Loader', 'load'));
    }

}

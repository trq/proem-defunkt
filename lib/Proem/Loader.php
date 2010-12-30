<?php
/**
 * @category   Proem
 * @package    Proem_Loader
 */

/**
 * @package    Proem_Loader
 *
 * An simple spl_autoload_register wrapper.
 */
class Proem_Loader
{
    /**
     * @var Origin_Loader
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
     * @return Origin_Loader
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
     * @return Origin_Loader
     */
    public static function load($class)
    {
        if (!class_exists($class, false)) {
            self::getInstance()->_doLoad($class);
        }
        return self::$_instance;
    }

    /**
     * Add a path to the include_path
     *
     * @param string $path
     * @return Origin_Loader
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
     * register the autoload function.
     *
     * @return bool
     */
    public function registerAutoload()
    {
        return spl_autoload_register(array('Proem_Loader', 'load'));
    }

    /**
     * Change a class name to a path and attempt to 'require' it.
     * @param string $class
     */
    private function _doLoad($class)
    {
        require_once str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
    }
}

<?php

/**
 * LiteMVC Application Framework
 *
 * Namespace autoloader
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Autoloader
 * @version 0.4.0
 */

namespace LiteMVC\Autoloader;

// Require base class as this may be the default autoloader
require_once 'AbstractAutoloader.php';

class Universal extends AbstractAutoloader
{

    /**
     * Configuration constants
     *
     * @var string
     */
    const CONFIG_NAMESPACE_MAP = 'namespaces';

    /**
     * Default configuration
     *
     * @var array
     */
    protected $_configDefaults = array(
        self::CONFIG_NAMESPACE_MAP => array(),
        self::CONFIG_AUTOREGISTER => true
    );

    /**
     * A map of namespaces that the autoloader will load
     *
     * @var array
     */
    private $_namespaces = array();

    /**
     * Override parents setConfig to setup the autoloader
     *
     * @param array $config
     */
    public function setConfig(array $config)
    {
        parent::setConfig($config);

        // Set namespace map from config
        $this->_namespaces = $this->_config[self::CONFIG_NAMESPACE_MAP];
    }

    /**
     * Attempt to autoload a class
     *
     * @param string $class
     */
    public function load($class)
    {
        // Match namespaces
        foreach ($this->_namespaces as $namespace => $path) {
            if (stripos($class, $namespace) === 0) {
                require_once str_replace('\\', '/', str_ireplace($namespace, $path, $class)) . '.php';
                break;
            }
        }
    }

    /**
     * Add a namespace to the autoloader
     *
     * @param $namespace
     * @param $path
     */
    public function addNamespace($namespace, $path)
    {
        $this->_namespaces[$namespace] = $path;
    }

}
<?php

/**
 * LiteMVC Application Framework
 *
 * Abstract autoloader
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Autoloader
 * @version 0.4.0-dev
 */

namespace LiteMVC\Autoloader;

use LiteMVC\Resource;

// Require base class as this may be the default autoloader
require_once __DIR__ . '/../Resource/AbstractResource.php';

abstract class AbstractAutoloader extends Resource\AbstractResource {

    // Configuration constants
    const CONFIG_AUTOREGISTER = "autoregister";

    /**
     * Override parents setConfig to setup the autoloader
     *
     * @param array $config
     */
    public function setConfig(array $config)
    {
        parent::setConfig($config);

        // Autoregister
        if ($this->_config[self::CONFIG_AUTOREGISTER]) {
            $this->register();
        }
    }

    /**
     * Check if this autoloader is registered
     *
     * @return bool
     */
    public function isRegistered()
    {
        return in_array(array($this, 'load'), spl_autoload_functions(), true);
    }

    /**
     * Register the autoloader
     */
    public function register()
    {
        spl_autoload_register(array($this, 'load'));
    }

    /**
     * Unregister the autoloader
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'load'));
    }

    /**
     * Attempt to autoload a class
     *
     * @param string $class
     */
    abstract public function load($class);

}
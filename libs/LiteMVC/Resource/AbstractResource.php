<?php

/**
 * LiteMVC Application Framework
 *
 * Base resource class
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Resource;

abstract class AbstractResource
{

    /**
     * Resource configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Default configuration
     *
     * @var array
     */
    protected $_configDefaults = array();

    /**
     * Configure resource
     *
     * @param array $config
     */
    public function __construct(array $config = null)
    {
        if ($config != null) {
            $this->setConfig($config);
        } else {
            $this->setConfig($this->_configDefaults);
        }
    }

    /**
     * Set resource configuration
     *
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->_config = array_merge($this->_configDefaults, $config);
    }

    /**
     * Get resource configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->_config;
    }

}
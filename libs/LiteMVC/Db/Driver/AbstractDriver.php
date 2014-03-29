<?php

/**
 * LiteMVC Application Framework
 *
 * Database driver abstract class
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Db\Driver;

use LiteMVC\Resource\AbstractResource;

abstract class AbstractDriver extends AbstractResource
{

    /**
     * Default configuration
     *
     * @var array
     */
    protected $_configDefaults = array(
        'host' => 'localhost'
    );

    /**
     * Check if the driver is available
     *
     * @return boolean
     */
    abstract public function isAvailable();

    /**
     * Get the name of the driver
     *
     * @return mixed
     */
    abstract public function getName();

    /**
     * Get driver connection
     *
     * @return Connection
     */
    abstract public function getConnection();

    /**
     * Get username
     *
     * @return string | null
     */
    public function getUsername()
    {
        if (isset($this->_config['username'])) {
            return $this->_config['username'];
        }
        return null;
    }

    /**
     * Get password
     *
     * @return string | null
     */
    public function getPassword()
    {
        if (isset($this->_config['password'])) {
            return $this->_config['password'];
        }
        return null;
    }


} 
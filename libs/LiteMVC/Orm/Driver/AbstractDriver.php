<?php

/**
 * LiteMVC Application Framework
 *
 * Abstract driver for Orm
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm\Driver;

use LiteMVC\Resource\AbstractResource;
use LiteMVC\Orm\Orm;
use LiteMVC\Orm\Driver\Exception;

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
     * Connection to the database
     *
     * @throws \LiteMVC\Orm\Driver\Exception
     */
    protected $_connection;

    /**
     * Allowed access modes
     *
     * @return int
     */
    public function getAccessMode()
    {
        if (isset($this->_config['access_mode'])) {
            return $this->_config['access_mode'];
        }
        return ORM::ACCESS_READ | ORM::ACCESS_WRITE;
    }

    /**
     * Connect to the database
     *
     * @throws \LiteMVC\Orm\Driver\Exception
     */
    abstract public function connect();

    /**
     * Check if driver is connected
     *
     * @return boolean
     */
    abstract public function isConnected();

    /**
     * Disconnect from the database
     *
     * @throws \LiteMVC\Orm\Driver\Exception
     */
    abstract public function disconnect();
}

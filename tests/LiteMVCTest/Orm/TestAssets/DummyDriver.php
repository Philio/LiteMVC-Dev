<?php

/**
 * LiteMVC Application Framework
 *
 * Dummy driver for ORM tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Orm\TestAssets;

use LiteMVC\Orm\Driver\AbstractDriver;
use LiteMVC\Orm\Driver\AbstractQuery;
use LiteMVC\Orm\Driver\AbstractResult;
use LiteMVC\Orm\Driver\Exception;

class DummyDriver extends AbstractDriver
{

    // Flag to indicate if driver is connected
    private $_connected = false;

    /**
     * Connect to the database
     *
     * @throws \LiteMVC\Orm\Driver\Exception
     */
    public function connect()
    {
        $this->_connected = true;
    }

    /**
     * Check if driver is connected
     *
     * @return boolean
     */
    public function isConnected()
    {
        return $this->_connected;
    }

    /**
     * Disconnect from the database
     *
     * @throws \LiteMVC\Orm\Driver\Exception
     */
    public function disconnect()
    {
        $this->_connected = false;
    }

    /**
     * Query the database
     *
     * @param string | AbstractQuery $statement
     * @param array | null $args
     * @return AbstractResult
     */
    public function query($statement, array $args = null)
    {
        // TODO: Implement query() method.
    }

}

<?php

/**
 * LiteMVC Application Framework
 *
 * Abstract Pdo driver for Orm
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm\Driver\PDO;

use LiteMVC\Orm\Driver\AbstractDriver;
use LiteMVC\Orm\Driver\Exception;

abstract class AbstractPdoDriver extends AbstractDriver {

    /**
     * Connection to the database
     *
     * @throws \LiteMVC\Orm\Driver\Exception
     */
    public function connect()
    {
        try {
            $this->_connection = new \PDO($this->_getDsn(), $this->_getUsername(), $this->_getPassword());
        } catch (\PDOException $e) {
            // Rethrow as a driver exception
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get connection DSN
     *
     * @return string
     */
    abstract protected function _getDsn();

    /**
     * Get connection username
     *
     * @return string
     */
    protected function _getUsername()
    {
        return null;
    }

    /**
     * Get connection password
     *
     * @return string
     */
    protected function _getPassword()
    {
        return null;
    }

    /**
     * Disconnect from the database
     *
     * @throws \LiteMVC\Orm\Driver\Exception
     */
    public function disconnect()
    {
        if (!$this->_connection instanceof \PDO) {
            throw new Exception('Not connected');
        }
        $this->_connection = null;
    }

}
<?php

/**
 * LiteMVC Application Framework
 *
 * Abstract Pdo driver for Orm
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm\Driver\Pdo;

use LiteMVC\Orm\Driver\AbstractDriver;
use LiteMVC\Orm\Driver\Exception;
use LiteMVC\Orm\Query\AbstractQuery;

abstract class AbstractPdoDriver extends AbstractDriver
{

    /**
     * Connection to the database
     *
     * @throws \LiteMVC\Orm\Driver\Exception
     */
    public function connect()
    {
        try {
            $this->_connection = new \PDO($this->_getDsn(), $this->_getUsername(), $this->_getPassword());
            $this->_connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->_connection->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_NATURAL);
            $this->_connection->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_NATURAL);
            $this->_connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
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
     * Check if driver is connected
     *
     * @return boolean
     */
    public function isConnected()
    {
        if ($this->_connection instanceof \PDO) {
            return true;
        }
        return false;
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

    /**
     * Query the database
     *
     * @param string | AbstractQuery $statement
     * @param array | null $args
     * @return PdoResult
     * @throws Exception
     * @throws \PDOException
     */
    public function query($statement, array $args = null)
    {
        // Check if statement is a query object
        if ($statement instanceof AbstractQuery) {
            $args = $statement->getQueryParams();
            $statement = $statement->buildQuery();
        }

        // If not connected, try and connect
        if (!$this->isConnected()) {
            $this->connect();
        }

        // Prepare statement
        $stmt = $this->_connection->prepare($statement);

        // Execute statement
        if ($args != null) {
            $stmt->execute($args);
        } else {
            $stmt->execute();
        }

        // Return result instance
        return new PdoResult($stmt);
    }

}

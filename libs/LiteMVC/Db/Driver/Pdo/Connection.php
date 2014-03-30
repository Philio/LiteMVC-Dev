<?php

/**
 * LiteMVC Application Framework
 *
 * Abstract PDO connection
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Db\Driver\Pdo;

use LiteMVC\Db\Driver\ConnectionInterface;
use LiteMVC\Db\Driver\Exception;
use LiteMVC\Db\Driver\StatementInterface;

class Connection implements ConnectionInterface
{

    /**
     * DSN
     *
     * @var string
     */
    private $_dsn;

    /**
     * Username
     *
     * @var string
     */
    private $_username;

    /**
     * Password
     *
     * @var string
     */
    private $_password;

    /**
     * Connection options
     *
     * @var array
     */
    private $_options;

    /**
     * PDO instance
     *
     * @var \PDO
     */
    private $_pdo;

    /**
     * Is in transaction
     *
     * @var boolean
     */
    private $_inTransaction = false;

    /**
     * Add connection settings
     *
     * @param string $dsn
     * @param string | null $username
     * @param string | null $password
     * @param array $options
     */
    public function __construct($dsn, $username = null, $password = null, array $options = null)
    {
        $this->_dsn = $dsn;
        $this->_username = $username;
        $this->_password = $password;
        $this->_options = $options;
    }

    /**
     * Connect to the database
     *
     * @return ConnectionInterface
     * @throws Exception
     */
    public function connect()
    {
        try {
            $this->_pdo = new \PDO($this->_dsn, $this->_username, $this->_password, $this->_options);
            $this->_pdo->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_NATURAL);
            $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->_pdo->setAttribute(\PDO::ATTR_ORACLE_NULLS, \PDO::NULL_NATURAL);
            $this->_pdo->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
            $this->_pdo->setAttribute(\PDO::ATTR_STATEMENT_CLASS, array('LiteMVC\Db\Driver\Pdo\Statement', array()));
            $this->_pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
        return $this;
    }

    /**
     * Check if connected to the database
     *
     * @return boolean
     */
    public function isConnected()
    {
        return !is_null($this->_pdo);
    }

    /**
     * Disconnect
     *
     * @return ConnectionInterface
     */
    public function disconnect()
    {
        if ($this->isConnected()) {
            $this->_pdo = null;
        }
        return $this;
    }

    /**
     * Prepare a statement
     *
     * @param string $sql
     * @return StatementInterface
     * @throws Exception
     */
    public function prepare($sql)
    {
        // Connect if necessary
        if (!$this->isConnected()) {
            $this->connect();
        }

        // Prepare statement
        try {
            return $this->_pdo->prepare($sql);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Execute query and return result as a statement
     *
     * @param string $sql
     * @return StatementInterface
     * @throws Exception
     */
    public function query($sql)
    {
        // Connect if necessary
        if (!$this->isConnected()) {
            $this->connect();
        }

        // Execute query
        try {
            return $this->_pdo->query($sql);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Execute a statement and return number of affected rows
     *
     * @param $sql
     * @return int
     * @throws Exception
     */
    public function exec($sql)
    {
        // Connect if necessary
        if (!$this->isConnected()) {
            $this->connect();
        }

        // Execute query
        try {
            return $this->_pdo->exec($sql);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Get last inserted id or value
     *
     * @param string $name
     * @return string
     * @throws Exception
     */
    public function lastInsertId($name = null)
    {
        // Connect if necessary
        if (!$this->isConnected()) {
            $this->connect();
        }

        // Get last id
        try {
            return $this->_pdo->lastInsertId($name);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Begin transaction
     *
     * @return boolean
     * @throws Exception
     */
    public function beginTransaction()
    {
        // Connect if necessary
        if (!$this->isConnected()) {
            $this->connect();
        }

        // Check if already in a transaction
        if ($this->inTransaction()) {
            return false;
        }

        // Begin transaction
        try {
            $this->_inTransaction = $this->_pdo->beginTransaction();
            return $this->_inTransaction;
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Is in a transaction
     *
     * @return boolean
     */
    public function inTransaction()
    {
        return $this->_inTransaction;
    }

    /**
     * Commit current transaction
     *
     * @return boolean
     * @throws Exception
     */
    public function commit()
    {
        // Should be connected
        if (!$this->isConnected()) {
            throw new Exception('Must be connected to commit a transaction');
        }

        // Should be in a transaction
        if (!$this->inTransaction()) {
            throw new Exception('Must be in a transaction to commit a transaction');
        }

        // Commit transaction
        try {
            if ($this->_pdo->commit()) {
                $this->_inTransaction = false;
                return true;
            }
            return false;
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Rollback current transaction
     *
     * @return boolean
     * @throws Exception
     */
    public function rollback()
    {
        // Should be connected
        if (!$this->isConnected()) {
            throw new Exception('Must be connected to rollback a transaction');
        }

        // Should be in a transaction
        if (!$this->inTransaction()) {
            throw new Exception('Must be in a transaction to rollback a transaction');
        }

        try {
            if ($this->_pdo->rollBack()) {
                $this->_inTransaction = false;
                return true;
            }
            return false;
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

}
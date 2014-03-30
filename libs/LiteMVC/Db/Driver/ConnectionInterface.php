<?php

/**
 * LiteMVC Application Framework
 *
 * Connection interface
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Db\Driver;

interface ConnectionInterface
{

    /**
     * Connect to the database
     *
     * @return ConnectionInterface
     */
    public function connect();

    /**
     * Check if connected to the database
     *
     * @return boolean
     */
    public function isConnected();

    /**
     * Disconnect
     *
     * @return ConnectionInterface
     */
    public function disconnect();

    /**
     * Prepare a statement
     *
     * @param string $sql
     * @return StatementInterface
     */
    public function prepare($sql);

    /**
     * Execute query and return result as a statement
     *
     * @param string $sql
     * @return StatementInterface
     */
    public function query($sql);

    /**
     * Execute a statement and return number of affected rows
     *
     * @param $sql
     * @return int
     */
    public function exec($sql);

    /**
     * Get last inserted id or value
     *
     * @param string $name
     * @return string
     */
    public function lastInsertId($name = null);

    /**
     * Begin transaction
     *
     * @return boolean
     */
    public function beginTransaction();

    /**
     * Is in a transaction
     *
     * @return boolean
     */
    public function inTransaction();

    /**
     * Commit current transaction
     *
     * @return boolean
     */
    public function commit();

    /**
     * Rollback current transaction
     *
     * @return boolean
     */
    public function rollback();

}
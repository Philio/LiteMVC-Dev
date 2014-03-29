<?php

/**
 * LiteMVC Application Framework
 *
 * Add class description here
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Db\Driver\Pdo;

use LiteMVC\Db\Driver\AbstractDriver;
use LiteMVC\Db\Driver\Exception;

abstract class AbstractPdoDriver extends AbstractDriver
{

    /**
     * Connection instance
     *
     * @var Connection
     */
    private $_connection;

    /**
     * Get driver connection
     *
     * @return Connection
     * @throws Exception
     */
    public function getConnection()
    {
        // Check that the driver is supported
        if (!$this->isAvailable()) {
            throw new Exception('The required driver is not installed');
        }

        // Get connection instance if necessary
        if (is_null($this->_connection)) {
            $this->_connection =
                new Connection($this->getDsn(), $this->getUsername(), $this->getPassword(), $this->getOptions());
        }
        return $this->_connection;
    }

    /**
     * Get connection DSN
     *
     * @return string
     */
    abstract public function getDsn();

    /**
     * Get options
     *
     * @return array | null
     */
    public function getOptions()
    {
        return null;
    }

} 
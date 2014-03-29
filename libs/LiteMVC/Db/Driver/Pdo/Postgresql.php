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

class Postgresql extends AbstractPdoDriver
{

    /**
     * Check if the driver is available
     *
     * @return boolean
     */
    public function isAvailable() {
        if (!extension_loaded('PDO')) {
            return false;
        }
        return in_array('pgsql', \PDO::getAvailableDrivers());
    }

    /**
     * Get the name of the driver
     *
     * @return mixed
     */
    public function getName()
    {
        return 'pdo_pgsql';
    }

    /**
     * Get connection DSN
     *
     * @return string
     */
    public function getDsn()
    {
        // Host is always defined by default
        $dsn = 'pgsql:host=' . $this->_config['host'];

        // Port
        if (isset($this->_config['port'])) {
            $dsn .= ';port=' . $this->_config['port'];
        }

        // Database name
        if (isset($this->_config['dbname'])) {
            $dsn .= ';dbname=' . $this->_config['dbname'];
        }

        // Username
        if (isset($this->_config['username'])) {
            $dsn .= ';user=' . $this->_config['username'];
        }

        // Password
        if (isset($this->_config['password'])) {
            $dsn .= ';password=' . $this->_config['password'];
        }

        return $dsn;
    }

}
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

class Mysql extends AbstractPdoDriver
{

    /**
     * Check if the driver is available
     *
     * @return boolean
     */
    public function isAvailable()
    {
        if (!extension_loaded('PDO')) {
            return false;
        }
        return in_array('mysql', \PDO::getAvailableDrivers());
    }

    /**
     * Get the name of the driver
     *
     * @return mixed
     */
    public function getName()
    {
        return 'pdo_mysql';
    }

    /**
     * Get connection DSN
     *
     * @return string
     */
    public function getDsn()
    {
        // Host is always defined by default
        $dsn = 'mysql:host=' . $this->_config['host'];

        // Port
        if (isset($this->_config['port'])) {
            $dsn .= ';port=' . $this->_config['port'];
        }

        // Database name
        if (isset($this->_config['dbname'])) {
            $dsn .= ';dbname=' . $this->_config['dbname'];
        }

        // Unix socket
        if (isset($this->_config['unix_socket'])) {
            $dsn .= ';unix_socket=' . $this->_config['unix_socket'];
        }

        // Character set
        if (isset($this->_config['charset'])) {
            $dsn .= ';charset=' . $this->_config['charset'];
        }

        return $dsn;
    }

    /**
     * Get options
     *
     * @return array | null
     */
    public function getOptions()
    {
        return array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    }

}
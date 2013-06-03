<?php

/**
 * LiteMVC Application Framework
 *
 * MySQL driver for Orm
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm\Driver\Pdo;

class Mysql extends AbstractPdoDriver
{

    /**
     * Get DSN for connecting to the database
     *
     * @return string
     */
    protected function _getDSN()
    {
        $dsn = 'mysql:host=' . $this->_config['host'];
        $dsn .= isset($this->_config['port']) ? ';port=' . $this->_config['port'] : null;
        $dsn .= isset($this->_config['dbname']) ? ';dbname=' . $this->_config['dbname'] : null;
        return $dsn;
    }

    /**
     * Get database username
     *
     * @return string
     */
    protected function _getUsername()
    {
        return isset($this->_config['username']) ? $this->_config['username'] : null;
    }

    /**
     * Get database password
     *
     * @return string
     */
    protected function _getPassword()
    {
        return isset($this->_config['password']) ? $this->_config['password'] : null;
    }

}
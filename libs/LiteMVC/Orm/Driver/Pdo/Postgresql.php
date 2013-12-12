<?php

/**
 * LiteMVC Application Framework
 *
 * PostgreSQL PDO driver for Orm
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm\Driver\Pdo;

class Postgresql extends AbstractPDODriver
{

    /**
     * Get DSN for connecting to the database
     *
     * @return string
     */
    protected function _getDSN()
    {
        $dsn = 'pgsql:host=' . $this->_config['host'];
        if (isset($this->_config['port'])) {
            $dsn .= ';port=' . $this->_config['port'];
        }
        if (isset($this->_config['dbname'])) {
            $dsn .= ';dbname=' . $this->_config['dbname'];
        }
        if (isset($this->_config['username'])) {
            $dsn .= ';user=' . $this->_config['username'];
        }
        if (isset($this->_config['password'])) {
            $dsn .= ';password=' . $this->_config['password'];
        }
        return $dsn;
    }

}

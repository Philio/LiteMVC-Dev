<?php

/**
 * LiteMVC Application Framework
 *
 * PostgreSQL driver for ORM
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0-dev
 */

namespace LiteMVC\ORM\Driver;

use LiteMVC\ORM\ORM;

class PostgreSQL extends AbstractDriver
{

    /**
     * Get DSN for connecting to the database
     *
     * @return string
     */
    protected function _getDSN()
    {
        $dsn = 'pgsql:host=' . $this->_config['host'];
        $this->_appendDSN($dsn, 'port', 'port');
        $this->_appendDSN($dsn, 'dbname', 'dbname');
        $this->_appendDSN($dsn, 'user', 'username');
        $this->_appendDSN($dsn, 'password', 'password');
        return $dsn;
    }

    /**
     * Append attribute to DSN if found in config
     *
     * @param $dsn
     * @param $attrib
     * @param $key
     */
    private function _appendDSN(&$dsn, $attrib, $key)
    {
        if (isset($this->_config[$key])) {
            $dsn .= ';' . $attrib . '=' . $this->_config[$key];
        }
    }

    /**
     * Map column type returned by the database to ORM constant
     *
     * @param string $type
     * @param int $precision
     * @return int
     */
    protected function _mapColumnType($type, $precision)
    {
        if (is_numeric($precision)) {
            return ORM::COL_NUMERIC;
        } else {
            return ORM::COL_STRING;
        }
    }

    /**
     * Map key type returned by the database to ORM constant
     *
     * @param string $type
     * @return int
     */
    protected function _mapKeyType($type)
    {
        switch ($type) {
            case 'PRIMARY KEY':
                return ORM::KEY_PRIMARY;
            case 'FOREIGN KEY':
                return ORM::KEY_FOREIGN;
            default:
                return null;
        }
    }

}
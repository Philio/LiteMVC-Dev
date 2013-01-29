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

class PostgreSQL extends AbstractDriver {
	
	/**
	 * Get DSN for connecting to the database
	 * 
	 * @return string
	 */
	protected function _getDSN() {
		$dsn = 'pgsql:host=' . $this->_config['host'];
		$dsn .= isset($this->_config['port']) ? ';port=' . $this->_config['port'] : null;
		$dsn .= isset($this->_config['dbname']) ? ';dbname=' . $this->_config['dbname'] : null;
		$dsn .= isset($this->_config['username']) ? ';user=' . $this->_config['username'] : null;
		$dsn .= isset($this->_config['password']) ? ';password=' . $this->_config['password'] : null;
		return $dsn;
	}

	/**
	 * Map column type returned by the database to a simple type defined in TYPE_* constants
	 * 
	 * @param string $type
	 * @param int $precision
	 * @return int
	 */
	protected function _mapColumnType($type, $precision) {
		if (is_numeric($precision)) {
			return ORM::COL_TYPE_INT;
		} else {
			return ORM::COL_TYPE_STR;
		}
	}

}
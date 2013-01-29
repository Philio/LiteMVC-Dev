<?php
/**
 * LiteMVC Application Framework
 * 
 * MySQL driver for ORM
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0-dev
 */
namespace LiteMVC\ORM\Driver;

abstract class AbstractDriver extends \PDO {
	
	/**
	 * Configuration
	 *
	 * @var array
	 */
	protected $_config = array(
		'host' => 'localhost'
	);
	
	/**
	 * Set configuration and connect to the database
	 * 
	 * @param array $config
	 */
	public function __construct(array $config) {
		// Merge config into defaults
		$this->_config = array_merge($this->_config, $config);
		
		// Connect to the database
		parent::__construct($this->_getDSN(), $this->_getUsername(), $this->_getPassword());
	}
	
	/**
	 * Get DSN for connecting to the database
	 * 
	 * @return string
	 */
	abstract protected function _getDSN();
	
	/**
	 * Get database username
	 * 
	 * @return string
	 */
	protected function _getUsername() {
		return null;
	}
	
	/**
	 * Get database password
	 * 
	 * @return string
	 */
	protected function _getPassword() {
		return null;
	}
	
	/**
	 * Get a list of columns for a specfic table
	 * 
	 * @param string $table
	 * @return array
	 */
	public function getColumns($table) {
		// Get column data from the database
		$columns = $this->_getInfomationSchemaColumns($table);
		if (!$columns) {
			throw new Exception('No column data for this table');
		}
		
		// Format and return column data
		$formatted = array();
		foreach ($columns as $column) {
			$formatted[$column['column_name']] = array(
				'type' => $this->_mapColumnType($column['data_type'], $column['numeric_precision']),
				'null' => strtolower($column['is_nullable']) == 'yes' ? true : false,
				'default' => $column['column_default']
			);
		}
		return $formatted;
	}
	
	/**
	 * Query information schema in standards compliant way for column data
	 * 
	 * @param string $table
	 * @return \PDOStatement
	 */
	protected function _getInfomationSchemaColumns($table) {
		return parent::query(sprintf(
			"
				SELECT column_name, data_type, numeric_precision, is_nullable, column_default
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE table_name = '%s'
			",
			$table
		), \PDO::FETCH_ASSOC);
	}
	
	/**
	 * Map column type returned by the database to a simple type defined in TYPE_* constants
	 * 
	 * @param string $type
	 * @param int $precision
	 * @return int
	 */
	abstract protected function _mapColumnType($type, $precision);
	
	/**
	 * Get a list of keys for a specific table
	 * 
	 * @param string $table
	 */
	public function getKeys($table) {
		$keys = $this->_getInformationSchemaKeys($table);
	}
	
	/**
	 * Query information schema in standards compliant way for key data
	 * 
	 * @param string $table
	 * @return \PDOStatement
	 */
	protected function _getInformationSchemaKeys($table) {
		return parent::query(sprintf(
			"
				SELECT t0.constraint_name, t0.constraint_type, t1.column_name
				FROM information_schema.table_constraints t0
				LEFT JOIN information_schema.key_column_usage t1
				ON t0.constraint_catalog = t1.constraint_catalog
				AND t0.constraint_schema = t1.constraint_schema
				AND t0.constraint_name = t1.constraint_name
				WHERE t0.table_name = '%s'
			",
			$table
		), \PDO::FETCH_ASSOC);
	}
	
}
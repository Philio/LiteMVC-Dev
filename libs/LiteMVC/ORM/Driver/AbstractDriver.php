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

abstract class AbstractDriver extends \PDO
{

    /**
     * Configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Set configuration and connect to the database
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->_config = $config;
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
    protected function _getUsername()
    {
        return null;
    }

    /**
     * Get database password
     *
     * @return string
     */
    protected function _getPassword()
    {
        return null;
    }

    public function getTables($database)
    {

    }

    /**
     * Query information schema in standards compliant way for list of tables in a database
     *
     * @param $database
     * @return \PDOStatement
     */
    protected function _getInformationSchemaTables($database)
    {
        return parent::query(sprintf(
            "
            ",
            $database
        ), \PDO::FETCH_ASSOC);
    }

    /**
     * Get a list of columns for a specfic table
     *
     * @param string $table
     * @return array
     */
    public function getColumns($table)
    {
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
    protected function _getInfomationSchemaColumns($table)
    {
        return parent::query(sprintf(
            "
            SELECT column_name, data_type, numeric_precision, is_nullable, column_default
            FROM information_schema.columns
            WHERE table_name = '%s'
			",
            $table
        ), \PDO::FETCH_ASSOC);
    }

    /**
     * Map column type returned by the database to ORM constant
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
    public function getKeys($table)
    {
        // Get column data from the database
        $keys = $this->_getInformationSchemaKeys($table);

        // Format and return keys
        $formatted = array();
        foreach ($keys as $key) {
            $type = $this->_mapKeyType($key['constraint_type']);
            if (is_null($type)) {
                continue;
            }
            $formatted[$key['constraint_name']] = array(
                'database' => $key['table_schema'],
                'table' => $key['table_name'],
                'column' => $key['column_name'],
                'type' => $type,
                'foreign_database' => $key['referenced_table_schema'],
                'foreign_table' => $key['referenced_table_name'],
                'foreign_column' => $key['referenced_column_name'],
            );
        }
        return $formatted;
    }

    /**
     * Query information schema in standards compliant way for key data
     *
     * @param string $table
     * @return \PDOStatement
     */
    protected function _getInformationSchemaKeys($table)
    {
        return parent::query(sprintf(
            "
            SELECT t0.table_schema, t0.table_name, t0.constraint_name, t0.constraint_type, t1.column_name,
                t1.referenced_table_schema, t1.referenced_table_name, t1.referenced_column_name
            FROM information_schema.table_constraints t0
            JOIN information_schema.key_column_usage t1
            ON t0.table_schema = t1.table_schema
            AND t0.table_name = t1.table_name
            AND t0.constraint_name = t1.constraint_name
            WHERE t0.table_name = '%s'
			",
            $table
        ), \PDO::FETCH_ASSOC);
    }

    /**
     * Map key type returned by the database to ORM constant
     *
     * @param string $type
     * @return int
     */
    abstract protected function _mapKeyType($type);

}
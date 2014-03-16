<?php

/**
 * LiteMVC Application Framework
 *
 * Abstract query builder for Orm
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm\Query;

abstract class AbstractQuery
{

    /**
     * Separator
     *
     * @var string
     */
    const SEPARATOR = '.';

    /**
     * Param
     *
     * @var string
     */
    const PARAM = '?';

    /**
     * Tables used in query
     *
     * @var array
     */
    protected $_tables = array();

    /**
     * Columns used in query
     *
     * @var array
     */
    protected $_columns = array();

    /**
     * Join statements
     *
     * @var array
     */
    protected $_joins = array();

    /**
     * Where statement
     *
     * @var string
     */
    protected $_where;

    /**
     * Bound params
     *
     * @var array
     */
    protected $_params = array();

    /**
     * Add a table to the query
     *
     * @param string $table
     * @param string|null $identifier
     * @return AbstractQuery
     */
    public function addTable($table, $identifier = null)
    {
        if (is_null($identifier)) {
            $this->_tables[] = $table;
        } else {
            $this->_tables[$identifier] = $table;
        }
        return $this;
    }

    /**
     * Add columns to the query
     *
     * @param string $column
     * @param string|null $table
     * @param string|null $identifier
     * @return AbstractQuery
     * @throws Exception
     */
    public function addColumn($column, $table = null, $identifier = null)
    {
        // Require a valid table name or identifier
        if (!array_key_exists($table, $this->_tables) && !in_array($table, $this->_tables)) {
            throw new Exception('Table name or identifier unknown');
        }

        // Prefix table name
        if (!is_null($table)) {
            $column = $table . self::SEPARATOR . $column;
        }

        if (is_null($identifier)) {
            $this->_columns[] = $column;
        } else {
            $this->_columns[$identifier] = $column;
        }
        return $this;
    }

    /**
     * Add where clause to query
     *
     * @param string $where
     * @param array $params
     * @return AbstractQuery
     * @throws Exception
     */
    public function where($where, array $params = null)
    {
        // Basic WHERE verification
        if (strstr($where, self::PARAM) !== false) {
            if ($params == null) {
                throw new Exception('Where statement contains bindings but no params given');
            }
            if (substr_count($where, self::PARAM) != count($params)) {
                throw new Exception('Number of params should match number of where bindings');
            }
        }

        $this->_where = $where;
        $this->_params = $params;
        return $this;
    }

    /**
     * Allow casting to string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->buildQuery();
    }

    /**
     * Children should implement to build SQL
     *
     * @return string
     */
    abstract public function buildQuery();

    /**
     * Get params that should be bound to this query
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->_params;
    }

    /**
     * Helper method to create list of tables in SQL format
     *
     * @return string
     */
    protected function _buildTableList()
    {
        // Get last table key
        end($this->_tables);
        $lastKey = key($this->_tables);
        reset($this->_tables);

        // Add tables to list
        $tableList = '';
        foreach ($this->_tables as $identifier => $table) {
            $tableList .= $table;
            if (!is_numeric($identifier)) {
                $tableList .= ' AS ' . $identifier;
            }
            if ($identifier != $lastKey) {
                $tableList .= ', ';
            }
        }
        return $tableList;
    }

    /**
     * Helper method to create list of columns in SQL format
     *
     * @return string
     */
    protected function _buildColumnList()
    {
        // Get last column key
        end($this->_columns);
        $lastKey = key($this->_columns);
        reset($this->_columns);

        // Add columns to query
        $column = '';
        foreach ($this->_columns as $identifier => $column) {
            $column .= $column;
            if (!is_numeric($identifier)) {
                $column .= ' AS ' . $identifier;
            }
            if ($identifier != $lastKey) {
                $column .= ', ';
            }
        }
        return $column;
    }

    /**
     * Helper method to build where statement
     *
     * @return string
     */
    protected function _buildWhere()
    {
        if ($this->_where != null) {
            return 'WHERE ' . $this->_where;
        }
    }

} 

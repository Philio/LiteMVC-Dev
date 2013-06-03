<?php

/**
 * LiteMVC Application Framework
 *
 * Abstract Model
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Model;

use LiteMVC\Resource;
use LiteMVC\Orm\Orm;

abstract class AbstractModel extends Resource\AbstractDataset
{

    /**
     * Database name, should be overriden by child
     *
     * @var string
     */
    protected $_database;

    /**
     * Table name, should be overriden by child
     *
     * @var string
     */
    protected $_table;

    /**
     * Schema, should be overriden by child
     *
     * An array based on the following format:
     *
     * array(
     *     'field_name' => array(
     *         'type' => Orm::COL_* constant,
     *         'nullable' => boolean,
     *         'default' => mixed
     *     ),
     *     ...
     * )
     *
     * @var array
     */
    protected $_schema;

    /**
     * Primary key, should be overriden by child
     *
     * An array of field names defined in $_schema
     *
     * @var array
     */
    protected $_primaryKey;

    /**
     * Relationships, should be overriden by child or null if no relationships exist
     *
     * An array based on the following format:
     *
     * array(
     *     'field_name' => array(
     *         array(
     *             'model' => string,
     *             'field' => string,
     *             'type' => Orm::REL_* constant
     *         ),
     *     ),
     *     ...
     * )
     *
     * @var array
     */
    protected $_relationships;

    /**
     * Original data from the database
     *
     * @var array
     */
    private $_originalData = array();

    /**
     * Get database name
     *
     * @return string
     * @throws Exception
     */
    public function getDatabase()
    {
        if ($this->_database === null) {
            throw new Exception('Database name not set');
        }
        return $this->_database;
    }

    /**
     * Get table name
     *
     * @return string
     * @throws Exception
     */
    public function getTable()
    {
        if ($this->_table === null) {
            throw new Exception('Table name not set');
        }
        return $this->_table;
    }

    /**
     * Get schema
     *
     * @return array
     * @throws Exception
     */
    public function getSchema()
    {
        if ($this->_table === null) {
            throw new Exception('Schema not set');
        }
        return $this->_schema;
    }

    /**
     * Get primary key
     *
     * @return array
     * @throws Exception
     */
    public function getPrimaryKey()
    {
        if ($this->_table === null) {
            throw new Exception('Primary key not set');
        }
        return $this->_primaryKey;
    }

    /**
     * Get relationships
     *
     * @return array
     * @throws Exception
     */
    public function getRelationships()
    {
        if ($this->_relationships === null) {
            throw new Exception('No relationships exist');
        }
        return $this->_relationships;
    }

}
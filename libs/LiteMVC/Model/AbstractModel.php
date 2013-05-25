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
 * @version 0.4.0-dev
 */

namespace LiteMVC\Model;

use LiteMVC\Resource;

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

}
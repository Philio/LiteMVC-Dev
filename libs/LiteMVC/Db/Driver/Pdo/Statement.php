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

use LiteMVC\Db\Driver\Exception;
use LiteMVC\Db\Driver\Statement as DriverStatement;

class Statement extends \PDOStatement implements DriverStatement
{

    /**
     * Protected constructor required by PDO
     */
    protected function __construct()
    {
    }

    /**
     * Bind a variable to a corresponding placeholder in the statement
     *
     * @param mixed $param
     * @param mixed $variable
     * @param integer $type
     * @param integer $length
     * @return boolean
     * @throws Exception
     */
    public function bindParam($param, &$variable, $type = \PDO::PARAM_STR, $length = null)
    {
        try {
            return parent::bindParam($param, $variable, $type, $length);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Bind a value to a corresponding placeholder in the statement
     *
     * @param mixed $param
     * @param mixed $value
     * @param integer $type
     * @return boolean
     * @throws Exception
     */
    public function bindValue($param, $value, $type = \PDO::PARAM_STR)
    {
        try {
            return parent::bindValue($param, $value, $type);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Execute query
     *
     * @param array $params
     * @return boolean
     * @throws Exception
     */
    public function execute(array $params = null)
    {
        try {
            return parent::execute($params);
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Get the number of rows affected by the last statement
     *
     * @return integer
     * @throws Exception
     */
    public function rowCount()
    {
        try {
            return parent::rowCount();
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Get the number of columns in the result set
     *
     * @return integer
     * @throws Exception
     */
    public function columnCount()
    {
        try {
            return parent::columnCount();
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Fetch the next row from a result set
     *
     * @return array
     * @throws Exception
     */
    public function fetch()
    {
        try {
            return parent::fetch();
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Fetch all rows in the result set
     *
     * @return array
     * @throws Exception
     */
    public function fetchAll()
    {
        try {
            return parent::fetchAll();
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

    /**
     * Close the cursor so the statement can be executed again
     *
     * @return boolean
     * @throws Exception
     */
    public function closeCursor()
    {
        try {
            return parent::closeCursor();
        } catch (\PDOException $e) {
            throw new Exception($e);
        }
    }

} 
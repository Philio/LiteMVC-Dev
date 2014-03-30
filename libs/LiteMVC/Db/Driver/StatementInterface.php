<?php

/**
 * LiteMVC Application Framework
 *
 * Statement interface
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Db\Driver;

interface StatementInterface
{

    /**
     * Bind a variable to a corresponding placeholder in the statement
     *
     * @param mixed $param
     * @param mixed $variable
     * @param integer $type
     * @param integer $length
     * @return boolean
     */
    public function bindParam($param, &$variable, $type = null, $length = null);

    /**
     * Bind a value to a corresponding placeholder in the statement
     *
     * @param mixed $param
     * @param mixed $value
     * @param integer $type
     * @return boolean
     */
    public function bindValue($param, $value, $type = null);

    /**
     * Execute query
     *
     * @param array $params
     * @return boolean
     */
    public function execute(array $params = null);

    /**
     * Get the number of rows affected by the last statement
     *
     * @return integer
     */
    public function rowCount();

    /**
     * Get the number of columns in the result set
     *
     * @return integer
     */
    public function columnCount();

    /**
     * Fetch the next row from a result set
     *
     * @return array
     */
    public function fetch();

    /**
     * Fetch all rows in the result set
     *
     * @return array
     */
    public function fetchAll();

    /**
     * Close the cursor so the statement can be executed again
     *
     * @return boolean
     */
    public function closeCursor();

} 
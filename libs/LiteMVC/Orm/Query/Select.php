<?php

/**
 * LiteMVC Application Framework
 *
 * Select builder for Orm
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm\Query;

class Select extends AbstractQuery
{

    /**
     * Add tables to query
     *
     * Example usage:
     *
     * from('table_1')
     * from(array('t1' => 'table_1'))
     * from('table_1', 'table_2')
     * from(array('t1' => 'table_1', 't2' => 'table_2'))
     *
     * @param mixed $table,...
     * @return Select
     */
    public function from($table)
    {
        // Multiple args accepted as an array
        if (func_num_args() > 1) {
            $table = func_get_args();
        }

        // Iterate array or add string
        if (is_array($table)) {
            foreach ($table as $identifier => $table) {
                $this->addTable($table, !is_numeric($identifier) ? $identifier : null);
            }
        } else {
            $this->addTable($table);
        }
        return $this;
    }

    /**
     * Add columns to query
     *
     * Example usage:
     *
     * columns('col_1', 'col_2', 'col_3');
     * columns(array('t1' => array('col_1', 'col_2', 'col_3')))
     * columns(array('t1' => array('c1' => 'col_1', 'c2' => 'col_2', 'c3' => 'col_3')))
     *
     * @param mixed $columns,...
     * @return Select
     * @throws Exception
     */
    public function columns($columns)
    {
        // Multiple args accepted as an array
        if (func_num_args() > 1) {
            $columns = func_get_args();
        }

        // Iterate array or add string
        if (is_array($columns)) {
            foreach ($columns as $key => $value) {
                if (is_array($value)) {
                    // Require a table name or identifier as the array key
                    if (is_numeric($key)) {
                        throw new Exception('Table name or identifier expected');
                    }

                    // Add all columns from array
                    foreach ($value as $identifier => $column) {
                        $this->addColumn($column, $key, !is_numeric($identifier) ? $identifier : null);
                    }
                } else {
                    $this->addColumn($value, !is_numeric($key) ? $key : null);
                }
            }
        }
        return $this;
    }

    /**
     * Generate SQL
     *
     * @return string
     */
    public function buildQuery()
    {
        return sprintf('SELECT %s FROM %s %s', $this->_buildColumnList(), $this->_buildTableList(),
            $this->_buildWhere());
    }

} 

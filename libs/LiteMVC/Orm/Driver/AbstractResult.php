<?php

/**
 * LiteMVC Application Framework
 *
 * Abstract result for Orm drivers
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm\Driver;

class AbstractResult implements \Countable, \Iterator
{

    /**
     * Number of affected rows
     *
     * @var int
     */
    protected $_affectedRows;

    /**
     * Row data
     *
     * @var array
     */
    protected $_data = array();

    /**
     * Current position
     *
     * @var int
     */
    private $_position = 0;

    /**
     * Count elements of an object
     *
     * @link http://php.net/manual/en/countable.count.php
     * @return int
     */
    public function count()
    {
        return count($this->_data);
    }

    /**
     * Return the current element
     *
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed
     */
    public function current()
    {
        return $this->_data[$this->_position];
    }

    /**
     * Move forward to next element
     *
     * @link http://php.net/manual/en/iterator.next.php
     * @return mixed
     */
    public function next()
    {
        $this->_position++;
        return $this->_data[$this->_position];
    }

    /**
     * Return the key of the current element
     *
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed
     */
    public function key()
    {
        return $this->_position;
    }

    /**
     * Checks if current position is valid
     *
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean
     */
    public function valid()
    {
        return array_key_exists($this->_position, $this->_data);
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link http://php.net/manual/en/iterator.rewind.php
     */
    public function rewind()
    {
        $this->_position = 0;
    }

}
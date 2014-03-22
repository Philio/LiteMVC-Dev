<?php

/**
 * LiteMVC Application Framework
 *
 * Base dataset resource class
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Resource;

abstract class AbstractDataset extends AbstractResource implements \Countable, \ArrayAccess
{

    /**
     * Stored data
     *
     * @var array
     */
    protected $_data;

    /**
     * Check if a key is set
     *
     * @param mixed $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->_data[$name]);
    }

    /**
     * Get a key
     *
     * @param mixed $name
     * @return mixed
     */
    public function &__get($name)
    {
        return $this->_data[$name];
    }

    /**
     * Set a key
     *
     * @param mixed $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    /**
     * Unset a key
     *
     * @param mixed $name
     */
    public function __unset($name)
    {
        unset($this->_data[$name]);
    }

    /**
     * Countable::count() implementation
     *
     * @link http://php.net/manual/en/countable.count.php
     * @return int
     */
    public function count()
    {
        return count($this->_data);
    }

    /**
     * ArrayAccess::offsetExists() implementation
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    /**
     * ArrayAccess::offsetGet() implementation
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset
     * @return mixed
     */
    public function &offsetGet($offset)
    {
        return $this->__get($offset);
    }

    /**
     * ArrayAccess::offsetSet() implementation
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->__set($offset, $value);
    }

    /**
     * ArrayAccess::offsetUnset() implementation
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->__unset($offset);
    }

}

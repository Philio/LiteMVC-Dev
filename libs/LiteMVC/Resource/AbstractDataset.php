<?php

/**
 * LiteMVC Application Framework
 *
 * Base dataset resource class
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0-dev
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
     * @return int
     */
    public function count()
    {
        return count($this->_data);
    }

    /**
     * ArrayAccess::offsetExists() implementation
     *
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
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->__unset($offset);
    }

}
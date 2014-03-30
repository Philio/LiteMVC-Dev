<?php

/**
 * LiteMVC Application Framework
 *
 * Orm
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm;

use LiteMVC\Model\AbstractModel;
use LiteMVC\Orm\Driver\AbstractResult;
use LiteMVC\Orm\Query\Select;
use LiteMVC\Resource;

class Orm extends Resource\AbstractResource
{

    /**
     * Column data types
     *
     * @var int
     */
    const COL_STRING = 0;
    const COL_NUMERIC = 1;

    /**
     * Key types
     *
     * @var int
     */
    const KEY_PRIMARY = 0;
    const KEY_FOREIGN = 1;

    /**
     * Table relationship types
     *
     * @var int
     */
    const REL_PARENT = 0;
    const REL_CHILD = 1;

    /**
     * Database access modes
     *
     * @var int
     */
    const ACCESS_READ = 1;
    const ACCESS_WRITE = 2;

    /**
     * Instantiated drivers
     *
     * @var array
     */
    private $_drivers = array();

    /**
     * Load a single row and map it to the specified model
     *
     * @param AbstractModel|string $model
     * @param mixed $id
     * @return AbstractModel
     * @throws \LiteMVC\Orm\Exception
     */
    public function load($model, $id)
    {
        // Get model
        $model = $this->_getModel($model);

        // Build select query
        $select = new Select();
        $select->from($model->getTable())
            ->columns('*')
            ->where($model->getPrimaryKey() . '=?', array($id));

        // Query the database
        $driver = $this->getDriver($model, self::ACCESS_READ);
        $result = $driver->query($select);

        // Map the result to the model
        return $result;
    }

    /**
     * Get the driver for a specific model for access mode
     *
     * @param string | AbstractModel $model
     * @param int $mode
     * @return AbstractDriver
     */
    public function getDriver($model, $mode)
    {
        // Get model and database name
        $model = $this->_getModel($model);
        $dbName = $model->getDatabase();

        // Check if driver is loaded
        if (isset($this->_drivers[$dbName])) {
            foreach ($this->_drivers[$dbName] as $driver) {
                if ($driver->getAccessMode() & $mode) {
                    return $driver;
                }
            }
        }

        // Load the driver
        $driver = $this->loadDriver($dbName, $mode);
        $this->_drivers[$dbName][] = $driver;
        return $driver;
    }

    /**
     * Load a driver for a database and access mode
     *
     * @param $dbName
     * @param $mode
     * @return AbstractDriver
     * @throws Exception
     */
    public function loadDriver($dbName, $mode)
    {
        // Check if configuration exists
        if (!isset($this->_config[$dbName])) {
            throw new Exception("Missing database driver configuration");
        }

        // Iterate configuration to find the configuration for a suitable driver
        foreach ($this->_config[$dbName] as $config) {
            $configMode =
                isset($config['access_mode']) ? $config['access_mode'] : self::ACCESS_READ | self::ACCESS_WRITE;
            if ($configMode & $mode) {
                return Driver\Factory::fromConfig($config);
            }
        }

        // No valid configuration was found
        throw new Exception("Missing database driver configuration");
    }

    /**
     * Instantiate and/or validate model
     *
     * @param string | AbstractModel $model
     * @return AbstractModel
     * @throws Exception
     */
    private function _getModel($model)
    {
        // Instantiate if necessary
        if (is_string($model)) {
            if (!class_exists($model)) {
                throw new Exception("Invalid model class name");
            }
            $model = new $model();
        }

        // Check inheritance
        if (!$model instanceof AbstractModel) {
            throw new Exception('Model should inherit from AbstractModel');
        }

        return $model;
    }

}

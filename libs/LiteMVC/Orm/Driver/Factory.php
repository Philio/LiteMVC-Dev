<?php

/**
 * LiteMVC Application Framework
 *
 * ORM driver factory
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm\Driver;

use LiteMVC\Orm\Orm;
use LiteMVC\Orm\Driver\AbstractDriver;
use LiteMVC\Orm\Driver\Exception;

class Factory
{

    /**
     * Driver names
     *
     * $var string
     */
    const DRIVER_PDO_MYSQL = "pdo_mysql";
    const DRIVER_PDO_POSTGRESQL = "pdo_postgres";

    /**
     * Get driver based on config
     *
     * @param array $config
     * @return \LiteMVC\Orm\Driver\AbstractDriver
     * @throws \LiteMVC\Orm\Driver\Exception
     */
    public static function fromConfig(array $config)
    {
        // If driver_class is specified, try and instantiate it
        if (isset($config['driver_class']) && class_exists($config['driver_class'])) {
            $driver = new $config['driver_class']($config);
            if (!$driver instanceof AbstractDriver) {
                throw new Exception('Database drivers must extend AbstractDriver');
            }
            return $driver;
        }

        // Check for valid config
        if (!isset($config['driver'])) {
            throw new Exception('No driver defined in configuration');
        }

        // Try and load a driver
        switch ($config['driver']) {
            case self::DRIVER_PDO_MYSQL:
                return new Pdo\Mysql($config);
            case self::DRIVER_PDO_POSTGRESQL:
                return new Pdo\Postgresql($config);
            default:
                throw new Exception(sprintf('Unknown driver %s in configuration', $config['driver']));
        }
    }



}
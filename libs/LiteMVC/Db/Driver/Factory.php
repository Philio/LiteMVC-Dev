<?php

/**
 * LiteMVC Application Framework
 *
 * Driver factory
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Db\Driver;

class Factory
{

    /**
     * Driver names
     *
     * $var string
     */
    const DRIVER_PDO_MYSQL = 'pdo_mysql';

    const DRIVER_PDO_POSTGRESQL = 'pdo_pgsql';

    const DRIVER_PDO_SQLITE = 'pdo_sqlite';

    /**
     * Get driver from config
     *
     * @param array $config
     * @return AbstractDriver
     * @throws Exception
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
                return new Pdo\MySql($config);
            case self::DRIVER_PDO_POSTGRESQL:
                return new Pdo\Postgresql($config);
            case self::DRIVER_PDO_SQLITE:
                return new Pdo\Sqlite($config);
            default:
                throw new Exception(sprintf('Unknown driver %s in configuration', $config['driver']));
        }
    }

} 
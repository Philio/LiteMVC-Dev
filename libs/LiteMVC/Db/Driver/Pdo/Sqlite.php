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

class Sqlite extends AbstractPdoDriver
{

    /**
     * Default configuration
     *
     * @var array
     */
    protected $_configDefaults = array(
        'version' => 3
    );

    /**
     * Check if the driver is available
     *
     * @return boolean
     */
    public function isAvailable()
    {
        if (!extension_loaded('PDO')) {
            return false;
        }
        return in_array('sqlite', \PDO::getAvailableDrivers());
    }

    /**
     * Get the name of the driver
     *
     * @return mixed
     */
    public function getName()
    {
        return 'pdo_sqlite';
    }

    /**
     * Get connection DSN
     *
     * @return string
     * @throws Exception
     */
    public function getDsn()
    {
        // Prefix based on SQLite version
        if ($this->_config['version'] == 3) {
            $dsn = 'sqlite:';
        } elseif ($this->_config['version'] == 2) {
            $dsn = 'sqlite2:';
        } else {
            throw new Exception('Unknown or missing SQLite version');
        }

        // Path or :memory:
        if (isset($this->_config['path'])) {
            $dsn .= $this->_config['path'];
        }

        return $dsn;
    }

}
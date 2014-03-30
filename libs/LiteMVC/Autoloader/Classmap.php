<?php

/**
 * LiteMVC Application Framework
 *
 * Classmap autoloader
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package Autoloader
 * @version 0.4.0
 */

namespace LiteMVC\Autoloader;

// Require base class as this may be the default autoloader
require_once 'AbstractAutoloader.php';

class Classmap extends AbstractAutoloader
{

    /**
     * Configuration constants
     *
     * @var string
     */
    const CONFIG_MAP = 'map';
    const CONFIG_RELATIVEPATH = 'relativepath';

    /**
     * Default configuration
     *
     * @var array
     */
    protected $_configDefaults = array(
        self::CONFIG_MAP => array(
            'LiteMVC\Autoloader\AbstractAutoloader' => '/Autoloader/AbstractAutoloader.php',
            'LiteMVC\Autoloader\Classmap' => '/Autoloader/Classmap.php',
            'LiteMVC\Autoloader\Universal' => '/Autoloader/Universal.php',
            'LiteMVC\Cli\Cli' => '/Cli/Cli.php',
            'LiteMVC\Cli\Module\App' => '/Cli/Module/App.php',
            'LiteMVC\Cli\Module\Exception' => '/Cli/Module/Exception.php',
            'LiteMVC\Cli\Module\Info' => '/Cli/Module/Info.php',
            'LiteMVC\Cli\Module\ModuleInterface' => '/Cli/Module/ModuleInterface.php',
            'LiteMVC\Cli\Module\Orm' => '/Cli/Module/Orm.php',
            'LiteMVC\Cli\Utils' => '/Cli/Utils.php',
            'LiteMVC\Config\Config' => '/Config/Config.php',
            'LiteMVC\Config\Exception' => '/Config/Exception.php',
            'LiteMVC\Config\Parser\Ini' => '/Config/Parser/Ini.php',
            'LiteMVC\Config\Parser\ParserInterface' => '/Config/Parser/ParserInterface.php',
            'LiteMVC\Config\Parser\Php' => '/Config/Parser/Php.php',
            'LiteMVC\Controller\AbstractController' => '/Controller/AbstractController.php',
            'LiteMVC\Controller\Exception' => '/Controller/Exception.php',
            'LiteMVC\Db\Driver\AbstractDriver' => '/Db/Driver/AbstractDriver.php',
            'LiteMVC\Db\Driver\ConnectionInterface' => '/Db/Driver/ConnectionInterface.php',
            'LiteMVC\Db\Driver\Exception' => '/Db/Driver/Exception.php',
            'LiteMVC\Db\Driver\Factory' => '/Db/Driver/Factory.php',
            'LiteMVC\Db\Driver\StatementInterface' => '/Db/Driver/StatementInterface.php',
            'LiteMVC\Db\Driver\Pdo\AbstractPdoDriver' => '/Db/Driver/Pdo/AbstractPdoDriver.php',
            'LiteMVC\Db\Driver\Pdo\Connection' => '/Db/Driver/Pdo/Connection.php',
            'LiteMVC\Db\Driver\Pdo\Mysql' => '/Db/Driver/Pdo/Mysql.php',
            'LiteMVC\Db\Driver\Pdo\Postgresql' => '/Db/Driver/Pdo/Postgresql.php',
            'LiteMVC\Db\Driver\Pdo\Sqlite' => '/Db/Driver/Pdo/Sqlite.php',
            'LiteMVC\Db\Driver\Pdo\Statement' => '/Db/Driver/Pdo/Statement.php',
            'LiteMVC\Model\AbstractModel' => '/Model/AbstractModel.php',
            'LiteMVC\Model\Exception' => '/Model/Exception.php',
            'LiteMVC\Orm\Exception' => '/Orm/Exception.php',
            'LiteMVC\Orm\Orm' => '/Orm/Orm.php',
            'LiteMVC\Orm\Query\AbstractQuery' => '/Orm/Query/AbstractQuery.php',
            'LiteMVC\Orm\Query\Exception' => '/Orm/Query/Exception.php',
            'LiteMVC\Orm\Query\Select' => '/Orm/Query/Select.php',
            'LiteMVC\Resource\AbstractDataset' => '/Resource/AbstractDataset.php',
            'LiteMVC\Resource\AbstractResource' => '/Resource/AbstractResource.php',
            'LiteMVC\View\AbstractView' => '/View/AbstractView.php',
            'LiteMVC\View\Exception' => '/View/Exception.php',
        ),
        self::CONFIG_RELATIVEPATH => 'libs/LiteMVC/',
        self::CONFIG_AUTOREGISTER => true
    );

    /**
     * The map of classes that this autoloader will load
     *
     * @var array
     */
    protected $_map = array();

    /**
     * Root path
     *
     * @var string
     */
    protected $_root;

    /**
     * Override parents setConfig to setup the autoloader
     *
     * @param array $config
     */
    public function setConfig(array $config)
    {
        parent::setConfig($config);

        // Set class map from config
        foreach ($this->_config[self::CONFIG_MAP] as $class => $path) {
            $this->_map[strtolower($class)] = $path;
        }

        // Set root path from config
        $this->_root = realpath(__DIR__ . '/../../../' . $this->_config[self::CONFIG_RELATIVEPATH]);
    }

    /**
     * Attempt to autoload a class
     *
     * @param string $class
     */
    public function load($class)
    {
        if (isset($this->_map[strtolower($class)])) {
            require_once $this->_root . $this->_map[strtolower($class)];
        }
    }

    /**
     * Add a map to the class map
     *
     * @param array $map
     */
    public function addMap(array $map)
    {
        foreach ($map as $class => $path) {
            $this->_map[strtolower($class)] = $path;
        }
    }

    /**
     * Add a class to the class map
     *
     * @param string $class
     * @param string $path
     */
    public function addClass($class, $path)
    {
        $this->_map[strtolower($class)] = $path;
    }

}

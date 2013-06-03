<?php

/**
 * LiteMVC Application Framework
 *
 * Classmap autoloader
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
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
            'LiteMVC\CLI\CLI' => '/CLI/CLI.php',
            'LiteMVC\CLI\Module\AbstractModule' => '/CLI/Module/AbstractModule.php',
            'LiteMVC\CLI\Module\App' => '/CLI/Module/App.php',
            'LiteMVC\CLI\Module\Exception' => '/CLI/Module/Exception.php',
            'LiteMVC\CLI\Module\Info' => '/CLI/Module/Info.php',
            'LiteMVC\CLI\Module\ORM' => '/CLI/Module/ORM.php',
            'LiteMVC\CLI\Utils' => '/CLI/Utils.php',
            'LiteMVC\Config\Config' => '/Config/Config.php',
            'LiteMVC\Config\Exception' => '/Config/Exception.php',
            'LiteMVC\Config\Parser\IniParser' => '/Config/Parser/IniParser.php',
            'LiteMVC\Config\Parser\ParserInterface' => '/Config/Parser/ParserInterface.php',
            'LiteMVC\Config\Parser\PhpParser' => '/Config/Parser/PhpParser.php',
            'LiteMVC\Controller\AbstractController' => '/Controller/AbstractController.php',
            'LiteMVC\Controller\Exception' => '/Controller/Exception.php',
            'LiteMVC\Model\AbstractModel' => '/Model/AbstractModel.php',
            'LiteMVC\Model\Exception' => '/Model/Exception.php',
            'LiteMVC\ORM\Driver\AbstractDriver' => '/ORM/Driver/AbstractDriver.php',
            'LiteMVC\ORM\Driver\Exception' => '/ORM/Driver/Exception.php',
            'LiteMVC\ORM\Driver\MySQL' => '/ORM/Driver/MySQL.php',
            'LiteMVC\ORM\Driver\PostgreSQL' => '/ORM/Driver/PostgreSQL.php',
            'LiteMVC\ORM\ORM' => '/ORM/ORM.php',
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
     * @param $class
     * @param $path
     */
    public function addClass($class, $path)
    {
        $this->_map[strtolower($class)] = $path;
    }

}
<?php

/**
 * LiteMVC Application Framework
 * 
 * Classmap autoloader
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0-dev
 */

namespace LiteMVC\Autoloader;

class Classmap {

    /**
     * Map of all framework classes
     *
     * @var array 
     */
    protected $_map = array(
        'LiteMVC\CLI\CLI' => '/CLI/CLI.php',
        'LiteMVC\CLI\Module\AbstractModule' => '/CLI/Module/AbstractModule.php',
        'LiteMVC\CLI\Module\App' => '/CLI/Module/App.php',
        'LiteMVC\CLI\Module\Info' => '/CLI/Module/Info.php',
        'LiteMVC\Config\Config' => '/Config/Config.php',
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
    );
    
    /**
     * A lowercase representation of the class map
     *
     * @var array
     */
    private $_lcMap = array();

    /**
     * Root director for the framework files
     *
     * @var string 
     */
    protected $_root;

    /**
     * Setup and register the autoloader
     * 
     * @param boolean $autoRegister
     */
    public function __construct($autoRegister = true) {
        // Set root directory
        $this->_root = realpath(__DIR__ . '/../');
        
        // Create lowercase map for better matching
        array_walk($this->_map, function($value, $key) {
            $this->_lcMap[strtolower($key)] = $value;
        });
        
        // Register the autoloader
        if ($autoRegister) {
            $this->register();
        }
    }

    /**
     * Register the autoloader
     */
    public function register() {
        spl_autoload_register(array($this, 'load'));
    }
    
    /**
     * Unregister the autoloader
     */
    public function unregister() {
        spl_autoload_unregister(array($this, 'load'));
    }

    /**
     * Attempt to autoload a class
     * 
     * @param string $class
     */
    public function load($class) {
        if (isset($this->_lcMap[strtolower($class)])) {
            require_once $this->_root . $this->_lcMap[strtolower($class)];
        }
    }

}
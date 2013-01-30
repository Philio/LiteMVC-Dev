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
        'LiteMVC\Controller\AbstractController' => '/Controller/AbstractController.php',
        'LiteMVC\Controller\Exception' => '/Controller/Exception.php',
        'LiteMVC\Model\AbstractModel' => '/Model/AbstractModel.php',
        'LiteMVC\Model\Exception' => '/Model/Exception.php',
        'LiteMVC\ORM\Driver\AbstractDriver' => '/ORM/Driver/AbstractDriver.php',
        'LiteMVC\ORM\Driver\Exception' => '/ORM/Driver/Exception.php',
        'LiteMVC\ORM\Driver\MySQL' => '/ORM/Driver/MySQL.php',
        'LiteMVC\ORM\Driver\PostgreSQL' => '/ORM/Driver/PostgreSQL.php',
        'LiteMVC\ORM\ORM' => '/ORM/ORM.php',
        'LiteMVC\View\AbstractView' => '/View/AbstractView.php',
        'LiteMVC\View\Exception' => '/View/Exception.php',
    );

    /**
     * Root director for the framework files
     *
     * @var string 
     */
    protected $_root;

    /**
     * Set the root director and register the autoloader
     * 
     * @param boolean $autoRegister
     */
    public function __construct($autoRegister = true) {
        $this->_root = realpath(__DIR__ . '/../');
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
        if (isset($this->_map[$class])) {
            require_once $this->_root . $this->_map[$class];
        }
    }

}
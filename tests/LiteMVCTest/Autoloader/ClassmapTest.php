<?php

/**
 * LiteMVC Application Framework
 *
 * Classmap autoload tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Autoloader
 * @version 0.4.0-dev
 */

namespace LiteMVCTest\Autoloader;

use LiteMVC\Autoloader;

class ClassmapTest extends \PHPUnit_Framework_TestCase
{

    private $_currentAutoloaders = array();

    public function setUp()
    {
        // Remove any LiteMVC autoloaders
        foreach (spl_autoload_functions() as $function) {
            if (is_array($function) && $function[0] instanceof \LiteMVC\Autoloader\Classmap) {
                $this->_currentAutoloaders[] = $function;
                spl_autoload_unregister($function);
            }
        }
    }

    public function tearDown()
    {
        // Restore original autoloaders
        foreach ($this->_currentAutoloaders as $function) {
            spl_autoload_register($function);
        }
    }

    /**
     * Test automatic framework loading
     */
    public function testFrameworkLoading()
    {
        $classmap = new Autoloader\Classmap();
        $this->assertContainsStrict(array($classmap, 'load'), spl_autoload_functions());
    }

    /**
     * Test Classmap::register()
     */
    public function testRegister()
    {
        $classmap = new Autoloader\Classmap(array(Autoloader\Classmap::CONFIG_AUTOREGISTER => false));
        $this->assertNotContainsStrict(array($classmap, 'load'), spl_autoload_functions());
        $classmap->register();
        $this->assertContainsStrict(array($classmap, 'load'), spl_autoload_functions());
    }

    /**
     * Test Classmap::unregister()
     */
    public function testUnregister()
    {
        $classmap = new Autoloader\Classmap();
        $this->assertContainsStrict(array($classmap, 'load'), spl_autoload_functions());
        $classmap->unregister();
        $this->assertNotContainsStrict(array($classmap, 'load'), spl_autoload_functions());
    }

    /**
     * Test Classmap::isRegistered()
     */
    public function testIsRegistered()
    {
        $classmap = new Autoloader\Classmap(array(Autoloader\Classmap::CONFIG_AUTOREGISTER => false));
        $this->assertFalse($classmap->isRegistered());
        $classmap->register();
        $this->assertTrue($classmap->isRegistered());
        $classmap->unregister();
        $this->assertFalse($classmap->isRegistered());
    }

    /**
     * Test Classmap::load()
     */
    public function testLoad()
    {
        $classmap = new Autoloader\Classmap(array(
            Autoloader\Classmap::CONFIG_MAP => array('LiteMVCTest\Autoloader\TestAssets\TestClass' => '/LiteMVCTest/Autoloader/TestAssets/TestClass.php'),
            Autoloader\Classmap::CONFIG_RELATIVEPATH => 'tests/'
        ));
        $this->assertInstanceOf('LiteMVCTest\Autoloader\TestAssets\TestClass', new \LiteMVCTest\Autoloader\TestAssets\TestClass());
    }

    /**
     * Test Classmap::addMap()
     */
    public function testAddMap()
    {
        $classmap = new Autoloader\Classmap(array(
            Autoloader\Classmap::CONFIG_MAP => array(),
            Autoloader\Classmap::CONFIG_RELATIVEPATH => 'tests/'
        ));
        $classmap->addMap(array('LiteMVCTest\Autoloader\TestAssets\TestClass' => '/LiteMVCTest/Autoloader/TestAssets/TestClass.php'));
        $this->assertInstanceOf('LiteMVCTest\Autoloader\TestAssets\TestClass', new \LiteMVCTest\Autoloader\TestAssets\TestClass());
    }

    /**
     * Test Classmap::addClass()
     */
    public function testAddClass()
    {
        $classmap = new Autoloader\Classmap(array(
            Autoloader\Classmap::CONFIG_MAP => array(),
            Autoloader\Classmap::CONFIG_RELATIVEPATH => 'tests/'
        ));
        $classmap->addClass('LiteMVCTest\Autoloader\TestAssets\TestClass', '/LiteMVCTest/Autoloader/TestAssets/TestClass.php');
        $this->assertInstanceOf('LiteMVCTest\Autoloader\TestAssets\TestClass', new \LiteMVCTest\Autoloader\TestAssets\TestClass());
    }

    /**
     * Assert that needle is in haystack using strict match
     *
     * @param $needle
     * @param $haystack
     */
    public function assertContainsStrict($needle, $haystack)
    {
        $this->assertTrue(in_array($needle, $haystack, true));
    }

    /**
     * Assert that needle is not in haystack using strict match
     *
     * @param $needle
     * @param $haystack
     */
    public function assertNotContainsStrict($needle, $haystack)
    {
        $this->assertFalse(in_array($needle, $haystack, true));
    }

}
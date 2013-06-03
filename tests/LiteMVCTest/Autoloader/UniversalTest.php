<?php

/**
 * LiteMVC Application Framework
 *
 * Universal autoload tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Autoloader
 * @version 0.4.0
 */

namespace LiteMVCTest\Autoloader;

use Composer\Autoload\AutoloadGenerator;
use LiteMVC\Autoloader;

require_once 'libs/LiteMVC/Autoloader/Universal.php';

class UniversalTest extends \PHPUnit_Framework_TestCase
{

    private $_currentAutoloaders = array();

    public function setUp()
    {
        // Remove any LiteMVC autoloaders
        foreach (spl_autoload_functions() as $function) {
            if (is_array($function) && ($function[0] instanceof Autoloader\Classmap || $function[0] instanceof Autoloader\Universal)) {
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
     * Test Universal::register()
     */
    public function testRegister()
    {
        $universal = new Autoloader\Universal(array(Autoloader\Universal::CONFIG_AUTOREGISTER => false));
        $this->assertNotContainsStrict(array($universal, 'load'), spl_autoload_functions());
        $universal->register();
        $this->assertContainsStrict(array($universal, 'load'), spl_autoload_functions());
    }

    /**
     * Test Universal::unregister()
     */
    public function testUnregister()
    {
        $universal = new Autoloader\Universal();
        $this->assertContainsStrict(array($universal, 'load'), spl_autoload_functions());
        $universal->unregister();
        $this->assertNotContainsStrict(array($universal, 'load'), spl_autoload_functions());
    }

    /**
     * Test Universal::isRegistered()
     */
    public function testIsRegistered()
    {
        $universal = new Autoloader\Universal(array(Autoloader\Universal::CONFIG_AUTOREGISTER => false));
        $this->assertFalse($universal->isRegistered());
        $universal->register();
        $this->assertTrue($universal->isRegistered());
        $universal->unregister();
        $this->assertFalse($universal->isRegistered());
    }

    /**
     * Test Universal::load()
     */
    public function testLoad()
    {
        $universal = new Autoloader\Universal(array(
            Autoloader\Universal::CONFIG_NAMESPACE_MAP => array(
                'LiteMVCTest\Autoloader\TestAssets' => realpath(__DIR__ . '/TestAssets')
            )
        ));
        $this->assertInstanceOf('LiteMVCTest\Autoloader\TestAssets\TestClassUniversal', new \LiteMVCTest\Autoloader\TestAssets\TestClassUniversal());
    }

    /**
     * Test Universal::addNamespace()
     */
    public function testAddNamespace()
    {
        $universal = new Autoloader\Universal();
        $universal->addNamespace('LiteMVCTest\Autoloader\TestAssets', realpath(__DIR__ . '/TestAssets'));
        $this->assertInstanceOf('LiteMVCTest\Autoloader\TestAssets\TestClassUniversal2', new \LiteMVCTest\Autoloader\TestAssets\TestClassUniversal2());
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
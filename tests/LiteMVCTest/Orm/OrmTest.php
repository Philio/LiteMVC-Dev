<?php

/**
 * LiteMVC Application Framework
 *
 * Orm tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Orm;

require_once __DIR__ . '/../Model/TestAssets/PersonModel.php';
require_once 'TestAssets/DummyDriver.php';

use LiteMVC\Orm\Orm;
use LiteMVCTest\Model\TestAssets\PersonModel;

class OrmTest extends \PHPUnit_Framework_TestCase
{

    /**
     * A basic test to check that the correct driver is loaded
     */
    public function testLoadDriver()
    {
        $orm = new Orm(array(
            'test_pdo_mysql' => array(
                array(
                    'driver' => 'pdo_mysql'
                )
            ),
            'test_pdo_postgres' => array(
                array(
                    'driver' => 'pdo_postgres'
                )
            )
        ));
        $this->assertInstanceOf('LiteMVC\Orm\Driver\Pdo\Mysql', $orm->loadDriver('test_pdo_mysql', Orm::ACCESS_READ));
        $this->assertInstanceOf('LiteMVC\Orm\Driver\Pdo\Postgresql', $orm->loadDriver('test_pdo_postgres', Orm::ACCESS_READ));
    }

    /**
     * Test missing config throws exception
     */
    public function testLoadDriverMissingConfig()
    {
        $this->setExpectedException('LiteMVC\Orm\Exception');
        $orm = new Orm();
        $orm->loadDriver('non_existant_config', Orm::ACCESS_READ);
    }

    /**
     * Test wrong config throws exception
     */
    public function testLoadDriverWrongConfig()
    {
        $this->setExpectedException('LiteMVC\Orm\Exception');
        $orm = new Orm(array(
            'test_pdo_mysql' => array(
                array(
                    'driver' => 'pdo_mysql'
                )
            )
        ));
        $orm->loadDriver('wrong_config', Orm::ACCESS_READ);
    }

    /**
     * Test wrong access level throws exception
     */
    public function testLoadDriverWrongAccessLevel()
    {
        $this->setExpectedException('LiteMVC\Orm\Exception');
        $orm = new Orm(array(
            'test_pdo_mysql' => array(
                array(
                    'driver' => 'pdo_mysql',
                    'access_mode' => Orm::ACCESS_READ
                )
            )
        ));
        $orm->loadDriver('test_pdo_mysql', Orm::ACCESS_WRITE);
    }

    /**
     * Test loading a driver from a model
     */
    public function testGetDriverFromModel()
    {
        $orm = new Orm(array(
            'test' => array(
                array(
                    'driver_class' => 'LiteMVCTest\Orm\TestAssets\DummyDriver'
                )
            )
        ));
        $this->assertInstanceOf('LiteMVCTest\Orm\TestAssets\DummyDriver', $orm->getDriver('LiteMVCTest\Model\TestAssets\PersonModel', Orm::ACCESS_READ));
    }

    /**
     * Test that an invalid model class name throws an exception
     */
    public function testGetDriverInvalidClassName()
    {
        $this->setExpectedException('LiteMVC\Orm\Exception');
        $orm = new Orm();
        $orm->getDriver('LiteMVCTest\Model\TestAssets\NonExistantModel', Orm::ACCESS_READ);
    }

    /**
     * Test that an invalid model throws an exception
     */
    public function testGetDriverInvalidModel()
    {
        $this->setExpectedException('LiteMVC\Orm\Exception');
        $orm = new Orm();
        $orm->getDriver(new \stdClass(), Orm::ACCESS_READ);
    }

    /**
     * Test that multiple model instances using the same driver get the same instance of the driver
     */
    public function testGetDriverSingleInstance()
    {
        $orm = new Orm(array(
            'test' => array(
                array(
                    'driver_class' => 'LiteMVCTest\Orm\TestAssets\DummyDriver'
                )
            )
        ));
        $this->assertSame($orm->getDriver('LiteMVCTest\Model\TestAssets\PersonModel', Orm::ACCESS_READ), $orm->getDriver('LiteMVCTest\Model\TestAssets\PersonModel', Orm::ACCESS_READ));
    }
    
    /**
     * Test that multiple drivers will be used when using specific read/write modes
     */
    public function testDifferentModes()
    {
        $orm = new Orm(array(
            'test' => array(
                array(
                    'driver_class' => 'LiteMVCTest\Orm\TestAssets\DummyDriver',
                    'access_mode' => Orm::ACCESS_READ
                ),
                array(
                    'driver_class' => 'LiteMVCTest\Orm\TestAssets\DummyDriver',
                    'access_mode' => Orm::ACCESS_WRITE
                )
            )
        ));
        $this->assertThat(
                $orm->getDriver('LiteMVCTest\Model\TestAssets\PersonModel', Orm::ACCESS_READ),
                $this->logicalNot(
                        $this->equalTo($orm->getDriver('LiteMVCTest\Model\TestAssets\PersonModel', Orm::ACCESS_WRITE))
                )
        );
    }

}

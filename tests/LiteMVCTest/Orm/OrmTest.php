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
    public function testLoadDrivers()
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
     * Test loading a driver from a model
     */
    public function testLoadDriverFromModel()
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

}
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

namespace LiteMVCTest\Db\Driver;

use LiteMVC\Db\Driver\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testDriverClass()
    {
        $config = array('driver_class' => 'LiteMVC\Db\Driver\Pdo\Mysql');
        $driver = Factory::fromConfig($config);
        $this->assertInstanceOf('LiteMVC\Db\Driver\Pdo\Mysql', $driver);
    }

    public function testInvalidDriverClass()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        $config = array('driver_class' => 'StdClass');
        Factory::fromConfig($config);
    }

    public function testInvalidConfig()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        Factory::fromConfig(array());
    }

    public function testPdoMysql()
    {
        $driver = Factory::fromConfig(array('driver' => 'pdo_mysql'));
        $this->assertInstanceOf('LiteMVC\Db\Driver\Pdo\Mysql', $driver);
    }

    public function testPdoPostgresql()
    {
        $driver = Factory::fromConfig(array('driver' => 'pdo_pgsql'));
        $this->assertInstanceOf('LiteMVC\Db\Driver\Pdo\Postgresql', $driver);
    }

    public function testPdoSqlite()
    {
        $driver = Factory::fromConfig(array('driver' => 'pdo_sqlite'));
        $this->assertInstanceOf('LiteMVC\Db\Driver\Pdo\Sqlite', $driver);
    }

    public function testUnkownDriver()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        Factory::fromConfig(array('driver' => 'pdo_mongodb'));
    }

}
 
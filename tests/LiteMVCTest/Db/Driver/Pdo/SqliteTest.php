<?php

/**
 * LiteMVC Application Framework
 *
 * SQLite driver tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Db\Driver\Pdo;

use LiteMVC\Db\Driver\Pdo\Sqlite;

class SqliteTest extends \PHPUnit_Framework_TestCase
{

    private $_config = array(
        'path' => ':memory:'
    );

    private $_configV2 = array(
        'version' => 2,
        'path' => ':memory:'
    );

    private $_configInvalid = array(
        'version' => 4,
        'path' => ':memory:'
    );

    /**
     * Check that PDO + SQLite are installed
     */
    public function setUp()
    {
        if (!extension_loaded('PDO')) {
            $this->markTestSkipped('PDO is not installed.');
        }
        if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
            $this->markTestSkipped('SQLite driver is not installed');
        }
    }

    public function testIsAvailable()
    {
        $sqlite = new Sqlite();

        $this->assertTrue($sqlite->isAvailable());
    }

    public function testGetName()
    {
        $sqlite = new Sqlite();

        $this->assertEquals('pdo_sqlite', $sqlite->getName());
    }

    public function testGetDsn()
    {
        $sqlite = new Sqlite();
        $sqlite->setConfig($this->_config);

        $this->assertEquals('sqlite::memory:', $sqlite->getDsn());
    }

    public function testGetDsnV2()
    {
        $sqlite = new Sqlite();
        $sqlite->setConfig($this->_configV2);

        $this->assertEquals('sqlite2::memory:', $sqlite->getDsn());
    }

    public function testGetDsnInvalid()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        $sqlite = new Sqlite();
        $sqlite->setConfig($this->_configInvalid);
        $sqlite->getDsn();
    }

}
 
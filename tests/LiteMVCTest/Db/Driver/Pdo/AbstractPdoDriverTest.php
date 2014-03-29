<?php

/**
 * LiteMVC Application Framework
 *
 * AbstractPdoDriver tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Db\Driver\Pdo;

class AbstractPdoDriverTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Check that PDO is installed
     */
    public function setUp()
    {
        if (!extension_loaded('PDO')) {
            $this->markTestSkipped('PDO is not installed.');
        }
    }

    /**
     * Get mock driver
     *
     * @return AbstractPdoDriver
     */
    public function getMockDriver()
    {
        return $this->getMockForAbstractClass('LiteMVC\Db\Driver\Pdo\AbstractPdoDriver');
    }

    public function testGetConnection()
    {
        $driver = $this->getMockDriver();
        $driver->expects($this->any())->method('isAvailable')->will($this->returnValue(true));
        $driver->expects($this->once())->method('getDsn')->will($this->returnValue('sqlite::memory:'));
        $connection = $driver->getConnection();

        $this->assertInstanceOf('LiteMVC\Db\Driver\Pdo\Connection', $connection);
        $this->assertAttributeInstanceOf('LiteMVC\Db\Driver\Pdo\Connection', '_connection', $driver);
        $this->assertSame($connection, $driver->getConnection());
    }

    public function testGetConnectionNoDriverException()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');

        $driver = $this->getMockDriver();
        $driver->expects($this->any())->method('isAvailable')->will($this->returnValue(false));

        $driver->getConnection();
    }

    public function testGetOptions()
    {
        $driver = $this->getMockDriver();

        $this->assertNull($driver->getOptions());
    }

}
 
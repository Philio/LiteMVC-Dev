<?php

/**
 * LiteMVC Application Framework
 *
 * AbstractDriver tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Db\Driver;

class AbstractDriverTest extends \PHPUnit_Framework_TestCase
{

    private $_config = array(
        'username' => 'test',
        'password' => 'testing'
    );

    /**
     * Get mock driver
     *
     * @return AbstractDriver
     */
    public function getMockDriver()
    {
        return $this->getMockForAbstractClass('LiteMVC\Db\Driver\AbstractDriver');
    }

    public function testGetUsernameUnconfigured()
    {
        $driver = $this->getMockDriver();

        $this->assertNull($driver->getUsername());
    }

    public function testGetPasswordUnconfigured()
    {
        $driver = $this->getMockDriver();

        $this->assertNull($driver->getPassword());
    }

    public function testGetUsername()
    {
        $driver = $this->getMockDriver();
        $driver->setConfig($this->_config);

        $this->assertEquals($this->_config['username'], $driver->getUsername());
    }

    public function testGetPassword()
    {
        $driver = $this->getMockDriver();
        $driver->setConfig($this->_config);

        $this->assertEquals($this->_config['password'], $driver->getPassword());
    }

}
 
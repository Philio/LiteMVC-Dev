<?php

/**
 * LiteMVC Application Framework
 *
 * Abstract Resource tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Resource
 * @version 0.4.0
 */

namespace LiteMVCTest\Resource;

class AbstractResourceTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test resource constructed with config
     */
    public function testResourceWithConfig()
    {
        $config = array('test' => 'test');
        $mock = $this->getMockForAbstractClass('LiteMVC\Resource\AbstractResource', array($config));
        $this->assertEquals($mock->getConfig(), $config);
    }

    /**
     * Test AbstractResource::setConfig() and AbstractResource::getConfig()
     */
    public function testResourceSetGetConfig()
    {
        $mock = $this->getMockForAbstractClass('LiteMVC\Resource\AbstractResource');
        $config = array('test' => 'test');
        $mock->setConfig($config);
        $this->assertEquals($mock->getConfig(), $config);
    }

}
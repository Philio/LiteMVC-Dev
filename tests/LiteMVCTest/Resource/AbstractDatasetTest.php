<?php

/**
 * LiteMVC Application Framework
 *
 * Abstract Dataset tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Resource
 * @version 0.4.0
 */

namespace LiteMVCTest\Resource;

class AbstractDatasetTest extends \PHPUnit_Framework_TestCase
{

    // Instance of the mock object
    private $_mock;

    /**
     * Generate a mock object from the abstract class
     */
    public function setUp()
    {
        $this->_mock = $this->getMockForAbstractClass('LiteMVC\Resource\AbstractDataset');
    }

    /**
     * Test AbstractDataset::__set() and AbstractDataset::__get()
     */
    public function testResourceSetGet()
    {
        $this->_mock->test = 'test';
        $this->assertEquals($this->_mock->test, 'test');
        $this->assertNull($this->_mock->madeup);
    }

    /**
     * Test AbstractDataset::__isset()
     */
    public function testResourceIsset()
    {
        $this->_mock->test = 'test';
        $this->assertTrue(isset($this->_mock->test));
        $this->assertFalse(isset($this->_mock->madeup));
    }

    /**
     * Test AbstractDataset::__unset()
     */
    public function testResourceUnset()
    {
        $this->_mock->test = 'test';
        unset($this->_mock->test);
        $this->assertFalse(isset($this->_mock->test));
    }

    /**
     * Test Countable::count() implementation
     */
    public function testResourceCount()
    {
        // Add some random data
        for ($i = 0; $i < 10; $i++) {
            $this->_mock->$i = mt_rand(0, 1000);
        }
        $this->assertCount(10, $this->_mock);
    }

    /**
     * Test ArrayAccess::offsetSet() and ArrayAccess::offsetGet() implementations
     */
    public function testResourceArraySetGet()
    {
        $this->_mock['test'] = 'test';
        $this->assertEquals($this->_mock['test'], 'test');
        $this->assertNull($this->_mock['madeup']);
    }

    /**
     * Test ArrayAccess::offsetExists() implementation
     */
    public function testResourceArrayIsset()
    {
        $this->_mock['test'] = 'test';
        $this->assertTrue(isset($this->_mock['test']));
        $this->assertFalse(isset($this->_mock['madeup']));
    }

    /**
     * Test ArrayAccess::offsetUnset() implementation
     */
    public function testResourceArrayUnset()
    {
        $this->_mock['test'] = 'test';
        unset($this->_mock['test']);
        $this->assertFalse(isset($this->_mock['test']));
    }

}
<?php

/**
 * LiteMVC Application Framework
 *
 * AbstractModel tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Model;

require_once('TestAssets/TestModel.php');

use LiteMVCTest\Model\TestAssets\TestModel;

class AbstractModelTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test AbstractModel::getDatabase()
     */
    public function testGetDatabase()
    {
        $model = new TestModel();
        $this->assertEquals($model->getDatabase(), 'test');
    }

    /**
     * Test AbstractModel::geTable()
     */
    public function testGetTable()
    {
        $model = new TestModel();
        $this->assertEquals($model->getTable(), 'person');
    }

    /**
     * Test AbstractModel::getSchema()
     */
    public function testGetSchema()
    {
        $model = new TestModel();
        $this->assertArrayHasKey('person_id', $model->getSchema());
        $this->assertArrayHasKey('name', $model->getSchema());
        $this->assertArrayHasKey('age', $model->getSchema());
    }

    /**
     * Test AbstractModel::getPrimaryKey()
     */
    public function testGetPrimaryKey()
    {
        $model = new TestModel();
        $this->assertContains('person_id', $model->getPrimaryKey());
    }

    /**
     * Test AbstractModel::getRelationships()
     */
    public function testGetRelationships()
    {
        $model = new TestModel();
        $this->assertTrue(array_key_exists('person_id', $model->getRelationships()));
    }

    /**
     * Test model without database name set
     */
    public function testBadDatabaseName()
    {
        $this->setExpectedException('LiteMVC\Model\Exception');
        $model = $this->getMockForAbstractClass('LiteMVC\Model\AbstractModel');
        $model->getDatabase();
    }

    /**
     * Test model without table name set
     */
    public function testBadTableName()
    {
        $this->setExpectedException('LiteMVC\Model\Exception');
        $model = $this->getMockForAbstractClass('LiteMVC\Model\AbstractModel');
        $model->getTable();
    }

    /**
     * Test model without schema set
     */
    public function testBadSchema()
    {
        $this->setExpectedException('LiteMVC\Model\Exception');
        $model = $this->getMockForAbstractClass('LiteMVC\Model\AbstractModel');
        $model->getSchema();
    }

    /**
     * Test model without primary key set
     */
    public function testBadPrimaryKey()
    {
        $this->setExpectedException('LiteMVC\Model\Exception');
        $model = $this->getMockForAbstractClass('LiteMVC\Model\AbstractModel');
        $model->getPrimaryKey();
    }

    /**
     * Test model without relationships set
     */
    public function testBadRelationships()
    {
        $this->setExpectedException('LiteMVC\Model\Exception');
        $model = $this->getMockForAbstractClass('LiteMVC\Model\AbstractModel');
        $model->getRelationships();
    }

}
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
 * @version 0.4.0-dev
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
        $this->assertEquals($model->getDatabase(), 'a_database');
    }

    /**
     * Test AbstractModel::geTable()
     */
    public function testGetTable()
    {
        $model = new TestModel();
        $this->assertEquals($model->getTable(), 'a_table');
    }

    /**
     * Test model without database name set
     */
    public function testBadDatabaseName()
    {
        $this->setExpectedException('LiteMVC\Model\Exception');
        $model = $this->getMockForAbstractClass('LiteMVC\Model\AbstractModel');
        $database = $model->getDatabase();
    }

    /**
     * Test model without table name set
     */
    public function testBadTableName()
    {
        $this->setExpectedException('LiteMVC\Model\Exception');
        $model = $this->getMockForAbstractClass('LiteMVC\Model\AbstractModel');
        $table = $model->getTable();
    }

}
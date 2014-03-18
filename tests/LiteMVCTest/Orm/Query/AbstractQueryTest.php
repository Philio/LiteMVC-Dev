<?php

/**
 * LiteMVC Application Framework
 *
 * AbstractQuery tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Orm\Query;

class AbstractQueryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Get mock instance
     *
     * @return \LiteMVC\Orm\Query\AbstractQuery
     */
    private function _getMock()
    {
        return $this->getMockForAbstractClass('LiteMVC\Orm\Query\AbstractQuery');
    }

    public function testAddTable()
    {
        $query = $this->_getMock();
        $query->addTable('table1');
        $tables = \PHPUnit_Framework_Assert::readAttribute($query, '_tables');
        $this->assertContains('table1', $tables);
    }

    public function testAddTableWithIdentifier()
    {
        $query = $this->_getMock();
        $query->addTable('table2', 't2');
        $tables = \PHPUnit_Framework_Assert::readAttribute($query, '_tables');
        $this->assertContains('table2', $tables);
        $this->assertArrayHasKey('t2', $tables);
        $this->assertEquals('table2', $tables['t2']);
    }

    public function testAddColumn()
    {
        $query = $this->_getMock();
        $query->addColumn('column1');
        $cols = \PHPUnit_Framework_Assert::readAttribute($query, '_columns');
        $this->assertContains('column1', $cols);
    }

    public function testAddColumnWithTable()
    {
        $query = $this->_getMock();
        $query->addTable('table1');
        $query->addColumn('column2', 'table1');
        $cols = \PHPUnit_Framework_Assert::readAttribute($query, '_columns');
        $this->assertContains('table1.column2', $cols);
    }

    public function testAddColumnWithIdentifier()
    {
        $query = $this->_getMock();
        $query->addColumn('column3', null, 'c3');
        $cols = \PHPUnit_Framework_Assert::readAttribute($query, '_columns');
        $this->assertContains('column3', $cols);
        $this->assertArrayHasKey('c3', $cols);
        $this->assertEquals('column3', $cols['c3']);
    }

    public function testAddColumnWithTableAndIdentifier()
    {
        $query = $this->_getMock();
        $query->addTable('table2');
        $query->addColumn('column4', 'table2', 'c4');
        $cols = \PHPUnit_Framework_Assert::readAttribute($query, '_columns');
        $this->assertContains('table2.column4', $cols);
        $this->assertArrayHasKey('c4', $cols);
        $this->assertEquals('table2.column4', $cols['c4']);
    }

    public function testAddColumnWithUnknownTable() {
        $this->setExpectedException('LiteMVC\Orm\Query\Exception');
        $query = $this->_getMock();
        $query->addColumn('column5', 'table1');
    }

    public function testWhereString() {
        $query = $this->_getMock();
        $query->where('column1 = 1');
        $where = \PHPUnit_Framework_Assert::readAttribute($query, '_where');
        $this->assertEquals('column1 = 1', $where);
    }

    public function testWhereParams() {
        $query = $this->_getMock();
        $query->where('column2 = ? AND column3 = ?', array(1, 2));
        $where = \PHPUnit_Framework_Assert::readAttribute($query, '_where');
        $this->assertEquals('column2 = ? AND column3 = ?', $where);
        $params = \PHPUnit_Framework_Assert::readAttribute($query, '_params');
        $this->assertEquals(array(1, 2), $params);
    }

    public function testWhereNoParams() {
        $this->setExpectedException('LiteMVC\Orm\Query\Exception');
        $query = $this->_getMock();
        $query->where('column3 = ?');
    }

    public function testWhereParamMismatch() {
        $this->setExpectedException('LiteMVC\Orm\Query\Exception');
        $query = $this->_getMock();
        $query->where('column4 = ? AND column5 = ?', array(1));
    }

    public function testBuildTableList() {
        $query = $this->_getMock();
        $query->addTable('table1');
        $query->addTable('table2', 't2');

        $reflection = new \ReflectionClass('LiteMVC\Orm\Query\AbstractQuery');
        $method = $reflection->getMethod('_buildTableList');
        $method->setAccessible(true);
        $this->assertEquals('table1, table2 AS t2', $method->invokeArgs($query, array()));
    }

    public function testBuildColumnList() {
        $query = $this->_getMock();
        $query->addTable('table1', 't1');
        $query->addTable('table2', 't2');
        $query->addColumn('column1');
        $query->addColumn('column2', 't1');
        $query->addColumn('column2', 't2', 't2c2');

        $reflection = new \ReflectionClass('LiteMVC\Orm\Query\AbstractQuery');
        $method = $reflection->getMethod('_buildColumnList');
        $method->setAccessible(true);
        $this->assertEquals('column1, t1.column2, t2.column2 AS t2c2', $method->invokeArgs($query, array()));
    }

    public function testBuildWhere() {
        $query = $this->_getMock();
        $query->where('column1 = ?', array(1));

        $reflection = new \ReflectionClass('LiteMVC\Orm\Query\AbstractQuery');
        $method = $reflection->getMethod('_buildWhere');
        $method->setAccessible(true);
        $this->assertEquals('WHERE column1 = ?', $method->invokeArgs($query, array()));
    }

    public function testBuildWhereNull() {
        $query = $this->_getMock();

        $reflection = new \ReflectionClass('LiteMVC\Orm\Query\AbstractQuery');
        $method = $reflection->getMethod('_buildWhere');
        $method->setAccessible(true);
        $this->assertNull($method->invokeArgs($query, array()));
    }

}
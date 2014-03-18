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

} 
<?php

/**
 * LiteMVC Application Framework
 *
 * Select tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Orm\Query;

use LiteMVC\Orm\Query\Select;

class SelectTest extends \PHPUnit_Framework_TestCase
{

    public function testFrom()
    {
        $select = new Select();
        $select->from('table1');
        $tables = \PHPUnit_Framework_Assert::readAttribute($select, '_tables');
        $this->assertContains('table1', $tables);
    }

    public function testFromMultipleArgs()
    {
        $select = new Select();
        $select->from('table1', 'table2');
        $tables = \PHPUnit_Framework_Assert::readAttribute($select, '_tables');
        $this->assertContains('table1', $tables);
        $this->assertContains('table2', $tables);
    }

    public function testFromArray()
    {
        $select = new Select();
        $select->from(array('t2' => 'table2'));
        $tables = \PHPUnit_Framework_Assert::readAttribute($select, '_tables');
        $this->assertContains('table2', $tables);
        $this->assertArrayHasKey('t2', $tables);
        $this->assertEquals('table2', $tables['t2']);
    }

    public function testColumns()
    {
        $select = new Select();
        $select->columns('column1');
        $cols = \PHPUnit_Framework_Assert::readAttribute($select, '_columns');
        $this->assertContains('column1', $cols);
    }

    public function testColumnsMultipleArgs()
    {
        $select = new Select();
        $select->columns('column1', 'column2', 'column3');
        $cols = \PHPUnit_Framework_Assert::readAttribute($select, '_columns');
        $this->assertContains('column1', $cols);
        $this->assertContains('column2', $cols);
        $this->assertContains('column3', $cols);
    }

    public function testColumnsTableArray()
    {
        $select = new Select();
        $select->from('table1');
        $select->columns(array('table1' => array('column1', 'column2', 'column3')));
        $cols = \PHPUnit_Framework_Assert::readAttribute($select, '_columns');
        $this->assertContains('table1.column1', $cols);
        $this->assertContains('table1.column2', $cols);
        $this->assertContains('table1.column3', $cols);
    }

    public function testColumnsTableArrayAlias()
    {
        $select = new Select();
        $select->from(array('t1' => 'table1'));
        $select->columns(array('t1' => array('column1', 'column2', 'column3')));
        $cols = \PHPUnit_Framework_Assert::readAttribute($select, '_columns');
        $this->assertContains('t1.column1', $cols);
        $this->assertContains('t1.column2', $cols);
        $this->assertContains('t1.column3', $cols);
    }

    public function testColumnsMissingTableIdentifier()
    {
        $this->setExpectedException('LiteMVC\Orm\Query\Exception');
        $select = new Select();
        $select->columns(array(array('column1', 'column2', 'column3')));
    }

    public function testBuildSimpleSelect() {
        $select = new Select();
        $select->from('table1');
        $select->columns('*');
        $this->assertEquals('SELECT * FROM table1', $select->buildQuery());
    }

    public function testBuildSimpleSelectWhere() {
        $select = new Select();
        $select->from('table1');
        $select->columns('*');
        $select->where('column1 = ?', array(1));
        $this->assertEquals('SELECT * FROM table1 WHERE column1 = ?', $select->buildQuery());
    }

}
 
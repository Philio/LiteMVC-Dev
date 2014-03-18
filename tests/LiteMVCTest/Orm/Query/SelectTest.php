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

    public function testFrom() {
        $select = new Select();
        $select->from('table1');
        $tables = \PHPUnit_Framework_Assert::readAttribute($select, '_tables');
        $this->assertContains('table1', $tables);
    }

}
 
<?php

/**
 * LiteMVC Application Framework
 *
 * Cli Orm module tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package Autoloader
 * @version 0.4.0
 */

namespace LiteMVCTest\Cli\Module;

use LiteMVC\Cli\Module\Orm;

class OrmTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Instance of the Orm module
     *
     * $var Orm
     */
    private $_orm;

    public function setUp()
    {
        $this->_orm = new Orm();
    }

    /**
     * Test Orm::showHelp()
     */
    public function testShowHelp()
    {
        $this->expectOutputRegex('/orm(.*)gen(.*)generate models from database/');
        $this->_orm->showHelp();
    }

}

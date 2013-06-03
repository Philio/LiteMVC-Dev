<?php

/**
 * LiteMVC Application Framework
 *
 * CLI ORM module tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Autoloader
 * @version 0.4.0
 */

namespace LiteMVCTest\CLI\Module;

use LiteMVC\CLI\Module\ORM;

class ORMTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Instance of the ORM module
     *
     * $var ORM
     */
    private $_orm;

    public function setUp()
    {
        $this->_orm = new ORM();
    }

    /**
     * Test ORM::showHelp()
     */
    public function testShowHelp()
    {
        $this->expectOutputRegex('/orm(.*)gen(.*)generate models from database/');
        $this->_orm->showHelp();
    }

}
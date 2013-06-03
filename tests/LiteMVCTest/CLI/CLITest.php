<?php

/**
 * LiteMVC Application Framework
 *
 * CLI tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Autoloader
 * @version 0.4.0
 */

namespace LiteMVCTest\CLI;

use LiteMVC\CLI\CLI;

class CLITest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test help is displayed when insufficient args to instantiate a module
     */
    public function testNoArgsShowHelp()
    {
        $this->expectOutputRegex('/Usage:(.*)Commands:/sm');
        new CLI(array());
    }

    /**
     * Test help is displayed when insufficient args to show info
     */
    public function testLoadInfoNoArgsShowHelp()
    {
        $this->expectOutputRegex('/Usage:(.*)Commands for info:/sm');
        new CLI(array(null, 'info'));
    }

    /**
     * Test help is displayed when insufficient args to show info
     */
    public function testLoadAppNoArgsShowHelp()
    {
        $this->expectOutputRegex('/Usage:(.*)Commands for app:/sm');
        new CLI(array(null, 'app'));
    }

    /**
     * Test help is displayed when insufficient args to show info
     */
    public function testLoadORMNoArgsShowHelp()
    {
        $this->expectOutputRegex('/Usage:(.*)Commands for orm:/sm');
        new CLI(array(null, 'orm'));
    }

}
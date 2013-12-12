<?php

/**
 * LiteMVC Application Framework
 *
 * Cli tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Autoloader
 * @version 0.4.0
 */

namespace LiteMVCTest\Cli;

use LiteMVC\Cli\Cli;

class CliTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test help is displayed when insufficient args to instantiate a module
     */
    public function testNoArgsShowHelp()
    {
        $this->expectOutputRegex('/Usage:(.*)Commands:/sm');
        new Cli(array());
    }

    /**
     * Test help is displayed when insufficient args to show info
     */
    public function testLoadInfoNoArgsShowHelp()
    {
        $this->expectOutputRegex('/Usage:(.*)Commands for info:/sm');
        new Cli(array(null, 'info'));
    }

    /**
     * Test help is displayed when insufficient args to show info
     */
    public function testLoadAppNoArgsShowHelp()
    {
        $this->expectOutputRegex('/Usage:(.*)Commands for app:/sm');
        new Cli(array(null, 'app'));
    }

    /**
     * Test help is displayed when insufficient args to show info
     */
    public function testLoadOrmNoArgsShowHelp()
    {
        $this->expectOutputRegex('/Usage:(.*)Commands for orm:/sm');
        new Cli(array(null, 'orm'));
    }

}

<?php

/**
 * LiteMVC Application Framework
 *
 * Cli info module tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package Autoloader
 * @version 0.4.0
 */

namespace LiteMVCTest\Cli\Module;

use LiteMVC\Cli\Module\Info;

class InfoTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Instance of the info module
     *
     * $var Info
     */
    private $_info;

    public function setUp()
    {
        $this->_info = new Info();
    }

    /**
     * Test Info::showHelp()
     */
    public function testShowHelp()
    {
        $this->expectOutputRegex(
                '/info(.*)all(.*)display all available information(.*)info(.*)version(.*)display software ' .
                'version(.*)info(.*)copyright(.*)display copyright information(.*)info(.*)license(.*)display ' .
                'license information/sm'
        );
        $this->_info->showHelp();
    }

    /**
     * Test Info::all()
     */
    public function testAll()
    {
        $this->expectOutputRegex('/Version 0\.4\.0(.*)Copyright \(c\) 2010 - ' . date('Y') . ' Phil Bayfield(.*)GNU General Public License version 3/sm');
        $this->_info->all();
    }

    /**
     * Test Info::version()
     */
    public function testVersion()
    {
        $this->expectOutputRegex('/Version 0\.4\.0/');
        $this->_info->version();
    }

    /**
     * Test Info::copyright()
     */
    public function testCopyright()
    {
        $this->expectOutputRegex('/Copyright \(c\) 2010 - ' . date('Y') . ' Phil Bayfield/');
        $this->_info->copyright();
    }

    /**
     * Test Info::license()
     */
    public function testLicense()
    {
        $this->expectOutputRegex('/GNU General Public License version 3/');
        $this->_info->license();
    }

}

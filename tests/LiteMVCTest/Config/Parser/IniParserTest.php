<?php

/**
 * LiteMVC Application Framework
 *
 * Config INI parser tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Config
 * @version 0.4.0
 */

namespace LiteMVCTest\Config\Parser;

use LiteMVC\Config\Parser\IniParser;

class IniParserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Instance of the parser
     *
     * @var IniParser
     */
    private $_parser;

    public function setUp()
    {
        $this->_parser = new IniParser();
    }

    /**
     * Test IniParser::parse()
     */
    public function testLoadIni()
    {
        $config = $this->_parser->parse(__DIR__ . '/../TestAssets/TestNoEnvConfig.ini');
        $this->assertTrue(isset($config['test']));
        $this->assertEquals($config['test']['integer'], 1);
        $this->assertTrue((bool)$config['test']['boolean']);
        $this->assertEquals($config['test']['string'], 'string');
        $this->assertContains('item1', $config['test']['array']);
        $this->assertContains('item2', $config['test']['array']);
    }

    /**
     * Test IniParser::parse() with optional environment
     */
    public function testLoadEnvIni()
    {
        $config = $this->_parser->parse(__DIR__ . '/../TestAssets/TestWithEnvConfig.ini', 'testing');
        $this->assertTrue(isset($config['test']));
        $this->assertEquals($config['test']['integer'], 1);
        $this->assertTrue((bool)$config['test']['boolean']);
        $this->assertEquals($config['test']['string'], 'string');
        $this->assertContains('item1', $config['test']['array']);
        $this->assertContains('item2', $config['test']['array']);
    }

    /**
     * Test IniParser::parse() with bad environment
     */
    public function testLoadIniBadEnv()
    {
        $this->setExpectedException('LiteMVC\Config\Exception');
        $this->_parser->parse(__DIR__ . '/../TestAssets/TestWithEnvConfig.ini', 'badenv');
    }

    /**
     * Test IniParser::parse() with environment that extends another environment
     */
    public function testLoadIniExtended()
    {
        $config = $this->_parser->parse(__DIR__ . '/../TestAssets/TestWithEnvConfig.ini', 'extended');
        $this->assertTrue((bool)$config['test']['extended']);
    }

    /**
     * Test IniParser::parse() when ini contains more than one extended environment
     */
    public function testLoadBadExtend()
    {
        $this->setExpectedException('LiteMVC\Config\Exception');
        $this->_parser->parse(__DIR__ . '/../TestAssets/TestWithEnvConfig.ini', 'badextend');
    }

}
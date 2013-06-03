<?php

/**
 * LiteMVC Application Framework
 *
 * Config PHP parser tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Config
 * @version 0.4.0
 */

namespace LiteMVCTest\Config\Parser;

use LiteMVC\Config\Parser\PhpParser;

class PhpParserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Instance of the PHP parser
     *
     * @var PhpParser
     */
    private $_parser;

    public function setUp()
    {
        $this->_parser = new PhpParser();
    }

    /**
     * Test PhpParser::parse()
     */
    public function testParse()
    {
        $config = $this->_parser->parse(__DIR__ . '/../TestAssets/TestNoEnvConfig.php');
        $this->assertTrue(isset($config['test']));
        $this->assertEquals($config['test']['integer'], 1);
        $this->assertTrue($config['test']['boolean']);
        $this->assertEquals($config['test']['string'], 'string');
        $this->assertContains('item1', $config['test']['array']);
        $this->assertContains('item2', $config['test']['array']);
    }

    /**
     * Test PhpParser::parse() with optional environment
     */
    public function testParseEnv()
    {
        $config = $this->_parser->parse(__DIR__ . '/../TestAssets/TestWithEnvConfig.php', 'testing');
        $this->assertTrue(isset($config['test']));
        $this->assertEquals($config['test']['integer'], 1);
        $this->assertTrue($config['test']['boolean']);
        $this->assertEquals($config['test']['string'], 'string');
        $this->assertContains('item1', $config['test']['array']);
        $this->assertContains('item2', $config['test']['array']);
    }

    /**
     * Test PhpParser::parse() with bad environment
     */
    public function testLoadPhpBadEnv()
    {
        $this->setExpectedException('LiteMVC\Config\Exception');
        $this->_parser->parse(__DIR__ . '/../TestAssets/TestWithEnvConfig.php', 'badenv');
    }

}
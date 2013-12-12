<?php

/**
 * LiteMVC Application Framework
 *
 * Config tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Config
 * @version 0.4.0
 */

namespace LiteMVCTest\Config;

use LiteMVC\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test Config::load() for php file
     */
    public function testLoadPhp()
    {
        $config = new Config\Config();
        $config->load(__DIR__ . '/TestAssets/TestNoEnvConfig.php', null, Config\Config::TYPE_PHP);
        $this->assertTrue(isset($config['test']));
        $this->assertEquals($config['test']['integer'], 1);
        $this->assertTrue($config['test']['boolean']);
        $this->assertEquals($config['test']['string'], 'string');
        $this->assertContains('item1', $config['test']['array']);
        $this->assertContains('item2', $config['test']['array']);
    }

    /**
     * Test Config::load() for ini file
     */
    public function testLoadIni()
    {
        $config = new Config\Config();
        $config->load(__DIR__ . '/TestAssets/TestNoEnvConfig.ini', null, Config\Config::TYPE_INI);
        $this->assertTrue(isset($config['test']));
        $this->assertEquals($config['test']['integer'], 1);
        $this->assertTrue((bool) $config['test']['boolean']);
        $this->assertEquals($config['test']['string'], 'string');
        $this->assertContains('item1', $config['test']['array']);
        $this->assertContains('item2', $config['test']['array']);
    }

    /**
     * Test Config::load() for nonexistant file
     */
    public function testLoadBadFile()
    {
        $this->setExpectedException('LiteMVC\Config\Exception');
        $config = new Config\Config();
        $config->load(__DIR__ . '/TestAssets/MadeUpConfig.php');
    }

    /**
     * Test Config::load() for php file with type detection
     */
    public function testLoadPhpDetect()
    {
        $config = new Config\Config();
        $config->load(__DIR__ . '/TestAssets/TestNoEnvConfig.php');
        $this->assertTrue(isset($config['test']));
    }

    /**
     * Test Config::load() for ini file with type detection
     */
    public function testLoadIniDetect()
    {
        $config = new Config\Config();
        $config->load(__DIR__ . '/TestAssets/TestNoEnvConfig.ini');
        $this->assertTrue(isset($config['test']));
    }

    /**
     * Test Config::load() for unknown file with type detection
     */
    public function testLoadBadExt()
    {
        $this->setExpectedException('LiteMVC\Config\Exception');
        $config = new Config\Config();
        $config->load(__DIR__ . '/TestAssets/TestConfigBadType.666');
    }

}

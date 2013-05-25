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
 * @version 0.4.0-dev
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
     * Test Config::load() for php file with environment
     */
    public function testLoadEnvPhp()
    {
        $config = new Config\Config();
        $config->load(__DIR__ . '/TestAssets/TestWithEnvConfig.php', 'testing', Config\Config::TYPE_PHP);
        $this->assertTrue(isset($config['test']));
        $this->assertEquals($config['test']['integer'], 1);
        $this->assertTrue($config['test']['boolean']);
        $this->assertEquals($config['test']['string'], 'string');
        $this->assertContains('item1', $config['test']['array']);
        $this->assertContains('item2', $config['test']['array']);
    }

    /**
     * Test Config::load() for php file with bad environment
     */
    public function testLoadPhpBadEnv()
    {
        $this->setExpectedException('LiteMVC\Config\Exception');
        $config = new Config\Config();
        $config->load(__DIR__ . '/TestAssets/TestWithEnvConfig.php', 'badenv', Config\Config::TYPE_PHP);
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
        $this->assertTrue((bool)$config['test']['boolean']);
        $this->assertEquals($config['test']['string'], 'string');
        $this->assertContains('item1', $config['test']['array']);
        $this->assertContains('item2', $config['test']['array']);
    }

    /**
     * Test Config::load() for ini file
     */
    public function testLoadEnvIni()
    {
        $config = new Config\Config();
        $config->load(__DIR__ . '/TestAssets/TestWithEnvConfig.ini', 'testing', Config\Config::TYPE_INI);
        $this->assertTrue(isset($config['test']));
        $this->assertEquals($config['test']['integer'], 1);
        $this->assertTrue((bool)$config['test']['boolean']);
        $this->assertEquals($config['test']['string'], 'string');
        $this->assertContains('item1', $config['test']['array']);
        $this->assertContains('item2', $config['test']['array']);
    }

    /**
     * Test Config::load() for ini file with bad environment
     */
    public function testLoadIniBadEnv()
    {
        $this->setExpectedException('LiteMVC\Config\Exception');
        $config = new Config\Config();
        $config->load(__DIR__ . '/TestAssets/TestWithEnvConfig.ini', 'badenv', Config\Config::TYPE_INI);
    }

    /**
     * Test Config::load() for ini file for an environment that extends another environment
     */
    public function testLoadIniExtended()
    {
        $config = new Config\Config();
        $config->load(__DIR__ . '/TestAssets/TestWithEnvConfig.ini', 'extended', Config\Config::TYPE_INI);
        $this->assertTrue((bool)$config['test']['extended']);
    }

    /**
     * Test Config::load() for ini file that contains more than one extended environment
     */
    public function testLoadBadExtend()
    {
        $this->setExpectedException('LiteMVC\Config\Exception');
        $config = new Config\Config();
        $config->load(__DIR__ . '/TestAssets/TestWithEnvConfig.ini', 'badextend', Config\Config::TYPE_INI);
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
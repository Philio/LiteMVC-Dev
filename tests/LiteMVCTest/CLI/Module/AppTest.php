<?php

/**
 * LiteMVC Application Framework
 *
 * Cli app module tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package Autoloader
 * @version 0.4.0
 */

namespace LiteMVCTest\Cli\Module;

use LiteMVC\Cli\Module\App;

class AppTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Instance of App module
     *
     * @var App
     */
    private $_app;

    public function setUp()
    {
        // Check that the workspace exists (git doesn't allow empty directories)
        if (!file_exists(__DIR__ . '/TestWorkspace')) {
            mkdir(__DIR__ . '/TestWorkspace', 0755);
        }

        // Remove any files in the test workspace directory
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__ . '/TestWorkspace', \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $filename => $fileInfo) {
            if ($fileInfo->isDir()) {
                rmdir($filename);
            } else {
                unlink($filename);
            }
        }

        // Instantiate module
        $this->_app = new App();
    }

    /**
     * Test App::showHelp()
     */
    public function testShowHelp()
    {
        $this->expectOutputRegex('/app(.*)create(.*)create a new application(.*)app(.*)rm(.*)remove an existing application/sm');
        $this->_app->showHelp();
    }

    /**
     * Test App::create()
     */
    public function testAppCreate()
    {
        $this->expectOutputRegex('/App created successfully/');
        $this->_app->create(array('test', __DIR__ . '/TestWorkspace'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/cache'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/cache/readme.txt'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/config'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/config/config.php'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/public'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/public/index.php'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/src'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/src/autoload.php'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/src/Controller'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/src/Controller/IndexController.php'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/src/Model'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/src/View'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/src/View/Layout'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/test/src/View/Page'));
    }

    /**
     * Test App::create() fails when app exists
     */
    public function testAppCreateDuplicate()
    {
        $this->setExpectedException('LiteMVC\Cli\Module\Exception');
        ob_start(); // Buffer the output, screws up PHPunit
        $this->_app->create(array('test', __DIR__ . '/TestWorkspace'));
        ob_end_clean(); // Discard the output buffer
        $this->_app->create(array('test', __DIR__ . '/TestWorkspace'));
    }

    /**
     * Test App::create() fails when params are invalid
     */
    public function testAppCreateInvalidParams()
    {
        $this->setExpectedException('LiteMVC\Cli\Module\Exception');
        $this->_app->create(array());
    }

    /**
     * Test App::create() creates path when it doesn't exist
     */
    public function testAppCreateNonExistantPath()
    {
        $this->expectOutputRegex('/App created successfully/');
        $this->_app->create(array('test', __DIR__ . '/TestWorkspace/newpath'));
        $this->assertTrue(file_exists(__DIR__ . '/TestWorkspace/newpath/test'));
    }

    /**
     * Test App::rm()
     */
    public function testAppRemove()
    {
        $this->expectOutputRegex('/App removed successfully/');
        $this->_app->create(array('test', __DIR__ . '/TestWorkspace'));
        $this->_app->rm(array('test', __DIR__ . '/TestWorkspace'));
        $this->assertFalse(file_exists(__DIR__ . '/TestWorkspace/test'));
    }

    /**
     * Test App::rm() fails when app doesn't exist
     */
    public function testAppRemoveNonExistant()
    {
        $this->setExpectedException('LiteMVC\Cli\Module\Exception');
        $this->_app->rm(array('test', __DIR__ . '/TestWorkspace'));
    }

    /**
     * Test App::rm() fails when params are invalid
     */
    public function testAppRemoveInvalidParams()
    {
        $this->setExpectedException('LiteMVC\Cli\Module\Exception');
        $this->_app->rm(array());
    }

}

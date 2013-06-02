<?php

/**
 * LiteMVC Application Framework
 *
 * CLI app module tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package Autoloader
 * @version 0.4.0-dev
 */

namespace LiteMVCTest\CLI\Module;

use LiteMVC\CLI\CLI;

class AppTest extends \PHPUnit_Framework_TestCase
{

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
    }

    /**
     * Test CLI app create
     */
    public function testAppCreate()
    {
        ob_start();
        new CLI(array(null, 'app', 'create', 'test', __DIR__ . '/TestWorkspace'));
        ob_end_clean();
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
     * Test CLI app remove
     */
    public function testAppRemove()
    {
        ob_start();
        new CLI(array(null, 'app', 'create', 'test', __DIR__ . '/TestWorkspace'));
        new CLI(array(null, 'app', 'rm', 'test', __DIR__ . '/TestWorkspace'));
        ob_end_clean();
        $this->assertFalse(file_exists(__DIR__ . '/TestWorkspace/test'));
    }

}
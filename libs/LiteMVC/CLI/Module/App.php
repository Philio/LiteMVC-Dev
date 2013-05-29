<?php

/**
 * LiteMVC Application Framework
 *
 * CLI application module
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0-dev
 */

namespace LiteMVC\CLI\Module;

use LiteMVC\CLI\CLI;

class App extends AbstractModule
{

    /**
     * Module name
     *
     * @var string
     */
    const NAME = 'app';

    /**
     * Show help for the module
     */
    public function showHelp()
    {
        $this->_cli->showHelpEntry(self::NAME, 'create', 'create a new application', array('<name>'), array('<path>'));
        $this->_cli->showHelpEntry(self::NAME, 'rm', 'remove an existing application', array('<name>'), array('<path>'));
    }

    /**
     * Create a new application
     *
     * @param $params
     */
    public function create($params)
    {
        // Check that at least 1 parameter was given
        if (count($params) == 0) {
            throw new Exception('Required parameter name missing');
        }
        $name = $params[0];
        $path = isset($params[1]) ? $params[1] : 'apps';

        // Check that an app doesn't already exist in the given path
        if (file_exists($path . '/' . $name)) {
            throw new Exception('An app of that name already exists');
        }

        // Create directories
        $this->_createDirectoryStructure($name, $path);

        // Copy files
        $this->_copyFiles($name, $path);
    }

    /**
     * Create directories for an application
     *
     * @param $name
     * @param $path
     */
    private function _createDirectoryStructure($name, $path)
    {
        echo $this->_cli->colorise('Creating directory structure...', CLI::COLOR_LIGHT_GREEN) . PHP_EOL . PHP_EOL;

        // Create path, if it doesn't exist
        if (!file_exists($path)) {
            $this->_createDirectory($path, 0755, true);
        }

        // Create app directories
        $this->_createDirectory($path . '/' . $name);
        $this->_createDirectory($path . '/' . $name . '/cache');
        $this->_createDirectory($path . '/' . $name . '/config');
        $this->_createDirectory($path . '/' . $name . '/public');
        $this->_createDirectory($path . '/' . $name . '/src');
        $this->_createDirectory($path . '/' . $name . '/src/Controller');
        $this->_createDirectory($path . '/' . $name . '/src/Model');
        $this->_createDirectory($path . '/' . $name . '/src/View');
        $this->_createDirectory($path . '/' . $name . '/src/View/Layout');
        $this->_createDirectory($path . '/' . $name . '/src/View/Page');

        echo PHP_EOL;
    }

    /**
     * Create a single directory and display console output
     *
     * @param $path
     */
    private function _createDirectory($path, $mode = 0755, $recursive = false)
    {
        mkdir($path, $mode, $recursive);
        echo $this->_cli->colorise(realpath($path), CLI::COLOR_LIGHT_CYAN) . PHP_EOL;
    }

    /**
     * Copy files into the application
     *
     * @param $name
     * @param $path
     */
    private function _copyFiles($name, $path)
    {
        echo $this->_cli->colorise('Copying files...', CLI::COLOR_LIGHT_GREEN) . PHP_EOL . PHP_EOL;

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__ . '/AppAssets/skel', \FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $filename => $fileInfo) {
            $contents = file_get_contents($filename);
            $contents = str_ireplace('{{ucfirst_name}}', ucfirst($name), $contents);
            $newFile = str_ireplace(__DIR__ . '/AppAssets/skel', $path . '/' . $name, $filename);
            file_put_contents($newFile, $contents);
            echo $this->_cli->colorise(realpath($newFile), CLI::COLOR_LIGHT_CYAN) . PHP_EOL;
        }
    }

}
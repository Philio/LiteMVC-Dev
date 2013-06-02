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
use LiteMVC\CLI\Utils;

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
        Utils::showHelpEntry(self::NAME, 'create', 'create a new application', array('<name>'), array('<path>'));
        Utils::showHelpEntry(self::NAME, 'rm', 'remove an existing application', array('<name>'), array('<path>'));
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

        echo PHP_EOL . Utils::colorise('App created successfully', Utils::COLOR_LIGHT_GREEN) . PHP_EOL;
    }

    public function rm($params)
    {
        // Check that at least 1 parameter was given
        if (count($params) == 0) {
            throw new Exception('Required parameter name missing');
        }
        $name = $params[0];
        $path = isset($params[1]) ? $params[1] : 'apps';

        // Check that the app exists
        if (!file_exists($path . '/' . $name) || !is_dir($path . '/' . $name)) {
            throw new Exception('No app of that name exists');
        }

        // Delete the app
        $this->_removeAll($path . '/' . $name);

        echo PHP_EOL . Utils::colorise('App removed successfully', Utils::COLOR_LIGHT_GREEN) . PHP_EOL;
    }

    /**
     * Create directories for an application
     *
     * @param $name
     * @param $path
     */
    private function _createDirectoryStructure($name, $path)
    {
        echo Utils::colorise('Creating directory structure...', Utils::COLOR_LIGHT_GREEN) . PHP_EOL . PHP_EOL;

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
        echo Utils::colorise(realpath($path), Utils::COLOR_LIGHT_CYAN) . PHP_EOL;
    }

    /**
     * Copy files into the application
     *
     * @param $name
     * @param $path
     */
    private function _copyFiles($name, $path)
    {
        echo Utils::colorise('Copying files...', Utils::COLOR_LIGHT_GREEN) . PHP_EOL . PHP_EOL;

        // Iterate skeleton directory and copy any files
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(__DIR__ . '/AppAssets/skel', \FilesystemIterator::SKIP_DOTS));
        $templateVars = $this->_createTemplateVars($name);
        foreach ($iterator as $filename => $fileInfo) {
            // Get file and replace template vars
            $contents = file_get_contents($filename);
            foreach ($templateVars as $search => $replace) {
                $contents = str_ireplace($search, $replace, $contents);
            }
            $newFile = str_ireplace(__DIR__ . '/AppAssets/skel', $path . '/' . $name, str_replace('.template', '', $filename));
            file_put_contents($newFile, $contents);
            echo Utils::colorise(realpath($newFile), Utils::COLOR_LIGHT_CYAN) . PHP_EOL;
        }
    }

    /**
     * Generate template replacements for copied default files
     *
     * @param $name
     * @return array
     */
    private function _createTemplateVars($name)
    {
        return array(
            '{{lowercase_name}}' => strtolower($name),
            '{{ucfirst_name}}' => ucfirst($name),
            '{{date_year}}' => date('Y')
        );
    }

    /**
     * Remove all contents of a directory
     *
     * @param $dir
     */
    private function _removeAll($dir)
    {
        echo Utils::colorise('Removing files...', Utils::COLOR_LIGHT_GREEN) . PHP_EOL . PHP_EOL;

        // Iterate director and remove contents
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $filename => $fileInfo) {
            echo Utils::colorise($fileInfo->getRealPath(), Utils::COLOR_LIGHT_CYAN) . PHP_EOL;
            if ($fileInfo->isDir()) {
                rmdir($filename);
            } else {
                unlink($filename);
            }
        }

        // Remove root directory
        echo Utils::colorise(realpath($dir), Utils::COLOR_LIGHT_CYAN) . PHP_EOL;
        rmdir($dir);
    }

}
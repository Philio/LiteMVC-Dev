<?php

/**
 * LiteMVC Application Framework
 *
 * Cli interpreter
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Cli;

use LiteMVC\Cli\Module;

class Cli
{

    /**
     * List of modules
     *
     * @var array
     */
    private $_modules = array(
        'info',
        'app',
        'orm'
    );

    /**
     * Run Cli
     *
     * @param array $argv
     */
    public function __construct(array $argv)
    {
        // Show the logo
        echo Utils::logo();

        // Load the specified module
        if (isset($argv[1]) && in_array(strtolower($argv[1]), $this->_modules)) {
            $className = 'LiteMVC\Cli\Module\\' . $argv[1];
            $module = new $className();

            // Load the module's action
            if (isset($argv[2]) && method_exists($module, $argv[2])) {
                try {
                    $module->$argv[2](array_slice($argv, 3));
                } catch (Module\Exception $e) {
                    $this->_showHelp(strtolower($argv[1]), $e->getMessage());
                }
            } else {
                $this->_showHelp(strtolower($argv[1]));
            }
        } else {
            $this->_showHelp();
        }
    }

    /**
     * Show help
     *
     * @param string $moduleName
     */
    private function _showHelp($moduleName = null, $error = null)
    {
        // Show error
        if ($error !== null) {
            echo Utils::colorise("Error: " . $error, Utils::COLOR_LIGHT_RED) . PHP_EOL . PHP_EOL;
        }

        // Show usage
        echo Utils::colorise('Usage:', Utils::COLOR_YELLOW) . PHP_EOL . PHP_EOL;
        Utils::showHelpEntry('<module name>', '<action name>', null, array('[required params]'), array('[optional params]'));

        // Show commands
        echo Utils::colorise('Commands' . ($moduleName ? ' for ' . $moduleName : null) . ':', Utils::COLOR_YELLOW) . PHP_EOL . PHP_EOL;
        if ($moduleName) {
            $className = 'LiteMVC\Cli\Module\\' . $moduleName;
            $module = new $className();
            $module->showHelp();
        } else {
            foreach ($this->_modules as $className) {
                $className = 'LiteMVC\Cli\Module\\' . $className;
                $module = new $className();
                $module->showHelp();
            }
        }
    }

}
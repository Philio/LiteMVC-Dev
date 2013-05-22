<?php

/**
 * LiteMVC Application Framework
 * 
 * CLI interpretor
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0-dev
 */

namespace LiteMVC\CLI;

class CLI {
    
    /**
     * List of modules
     *
     * @var array 
     */
    private $_modules = array(
        'info',
        'app',
    );
    
    /**
     * Color codes
     * 
     * @var string
     */
    const COLOR_BLACK = "\033[0;30m";
    const COLOR_DARK_GRAY = "\033[1;30m";
    const COLOR_RED = "\033[0;31m";
	const COLOR_LIGHT_RED = "\033[1;31m";
    const COLOR_GREEN = "\033[0;32m";
    const COLOR_LIGHT_GREEN = "\033[1;32m";
    const COLOR_BROWN = "\033[0;33m";
    const COLOR_YELLOW = "\033[1;33m";
    const COLOR_BLUE = "\033[0;34m";
    const COLOR_LIGHT_BLUE = "\033[1;34m";
    const COLOR_PURPLE = "\033[0;35m";
    const COLOR_LIGHT_PURPLE = "\033[1;35m";
    const COLOR_CYAN = "\033[0;36m";
    const COLOR_LIGHT_CYAN = "\033[1;36m";
    const COLOR_LIGHT_GREY = "\033[0;37m";
    const COLOR_WHITE = "\033[1;37m";
    const COLOR_TERMINATOR = "\033[0m";
    
    /**
     * CLI command
     * 
     * @var string
     */
    const CMD = 'LiteMVC';
    
    /**
     * Run CLI
     * 
     * @param array $argv
     */
    public function __construct(array $argv) {
        // Show the logo
        echo $this->_logo();
        
        // Load the specified module
        if (isset($argv[1]) && in_array(strtolower($argv[1]), $this->_modules)) {
            $className = 'LiteMVC\CLI\Module\\' . $argv[1];
            $module = new $className($this);
            
            // Load the module's action
            if (isset($argv[2]) && method_exists($module, $argv[2])) {
                echo $module->$argv[2](array_slice($argv, 2));
            } else {
                $this->_showHelp(strtolower($argv[1]));
            }
        } else {
            $this->_showHelp();
        }
    }

    /**
     * Apply BASH color codes to some text
     * 
     * @param type $text
     * @param type $color
     */
    public function colorise($text, $color) {
        return $color . $text . self::COLOR_TERMINATOR;
    }

    /**
     * Show help entry
     * 
     * @param string $moduleName
     * @param string $actionName
     * @param string $desc
     * @param array $reqParams
     * @param array $optParams
     */
    public function showHelpEntry($moduleName, $actionName, $desc = null, array $reqParams = array(), array $optParams = array()) {
        // Merge all required params
        $req = array_merge(array(self::CMD, $moduleName, $actionName), $reqParams);
        
        // Show required params in green
        $reqFmt = count($optParams) ? '%s' : '%-30s';
        echo $this->colorise(sprintf($reqFmt, implode(' ', $req)), self::COLOR_LIGHT_GREEN);
        
        // Show optional params in cyan
        if (count($optParams)) {
            $optFmt = strlen(implode(' ', $req) . ' ') < 30 ? '%-' . (30 - strlen(implode(' ', $req) . ' ')) . 's' : '%s'; 
            echo ' ' . $this->colorise(sprintf($optFmt, implode(' ', $optParams)), self::COLOR_LIGHT_CYAN);
        }
        
        // Show description in white
        if ($desc) {
            echo ' ' . $this->colorise($desc, self::COLOR_WHITE);
        }
        
        echo PHP_EOL . PHP_EOL;
    }
    
    /**
     * A large ASCII logo
     * 
     * @return string
     */
    private function _logo() {
        return ' _     _ _       __  ____     ______' . PHP_EOL .
            '| |   (_) |_ ___|  \/  \ \   / / ___|' . PHP_EOL .
            '| |   | | __/ _ \ |\/| |\ \ / / |' . PHP_EOL .
            '| |___| | ||  __/ |  | | \ V /| |___' . PHP_EOL .
            '|_____|_|\__\___|_|  |_|  \_/  \____|' . PHP_EOL . PHP_EOL;
    }
    
    /**
     * Show help
     * 
     * @param string $moduleName
     */
    private function _showHelp($moduleName = null) {
        // Show usage
        echo $this->colorise('Usage:', self::COLOR_YELLOW) . PHP_EOL . PHP_EOL;
        $this->showHelpEntry('<module name>', '<action name>', null, array('[required params]'), array('[optional params]'));
        
        // Show commands
        echo $this->colorise('Commands' . ($moduleName ? ' for ' . $moduleName : null) . ':', self::COLOR_YELLOW) . PHP_EOL . PHP_EOL;
        if ($moduleName) {
            $className = 'LiteMVC\CLI\Module\\' . $moduleName;
            $module = new $className($this);
            $module->showHelp();
        } else {
            foreach ($this->_modules as $className) {
                $className = 'LiteMVC\CLI\Module\\' . $className;
                $module = new $className($this);
                $module->showHelp();
            }
        }
    }

}
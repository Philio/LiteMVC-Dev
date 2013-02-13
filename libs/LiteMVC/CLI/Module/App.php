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

class App extends AbstractModule {
    
    /**
     * Module name
     * 
     * @var string
     */
    const NAME = 'app';
    
    /**
     * Show help for the module
     */
    public function showHelp() {
        $this->_cli->showHelpEntry(self::NAME, 'create', 'create a new application', array('<name>'));
        $this->_cli->showHelpEntry(self::NAME, 'rm', 'remove an existing application', array('<name>'));
    }
    
}
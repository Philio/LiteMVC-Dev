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

abstract class AbstractModule
{

    /**
     * Module name
     *
     * @var string
     */
    const NAME = '';

    /**
     * An instance of the CLI class
     *
     * @var CLI
     */
    protected $_cli;

    /**
     * Set the CLI object
     *
     * @param CLI $cli
     */
    public function __construct(CLI $cli)
    {
        $this->_cli = $cli;
    }

    /**
     * Show help for the module
     */
    abstract public function showHelp();

}
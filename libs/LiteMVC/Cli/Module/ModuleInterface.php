<?php

/**
 * LiteMVC Application Framework
 *
 * Cli module interface
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Cli\Module;

interface ModuleInterface
{

    /**
     * Show help for the module
     */
    public function showHelp();

}
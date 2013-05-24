<?php

/**
 * LiteMVC Application Framework
 *
 * CLI information module
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0-dev
 */

namespace LiteMVC\CLI\Module;

use LiteMVC\CLI\CLI;

class Info extends AbstractModule
{

    /**
     * Module name
     *
     * @var string
     */
    const NAME = 'info';

    /**
     * Show help for the module
     */
    public function showHelp()
    {
        $this->_cli->showHelpEntry(self::NAME, 'all', 'display all available information');
        $this->_cli->showHelpEntry(self::NAME, 'version', 'display software version');
        $this->_cli->showHelpEntry(self::NAME, 'copyright', 'display copyright information');
        $this->_cli->showHelpEntry(self::NAME, 'license', 'display license information');
    }

    /**
     * All available info
     *
     * @return string
     */
    public function all()
    {
        return $this->version() . $this->copyright() . $this->license();
    }

    /**
     * The current version
     *
     * @return string
     */
    public function version()
    {
        return $this->_cli->colorise('Version 0.4.0-dev' . PHP_EOL, CLI::COLOR_LIGHT_GREY);
    }

    /**
     * Copyright information
     *
     * @return string
     */
    public function copyright()
    {
        return $this->_cli->colorise('Copyright (c) 2010 - ' . date('Y') . ' Phil Bayfield' . PHP_EOL, CLI::COLOR_LIGHT_GREY);
    }

    /**
     * License information
     *
     * @return string
     */
    public function license()
    {
        return $this->_cli->colorise('GNU General Public License version 3' . PHP_EOL, CLI::COLOR_LIGHT_GREY);
    }

}
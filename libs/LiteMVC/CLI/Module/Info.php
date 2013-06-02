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
use LiteMVC\CLI\Utils;

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
        Utils::showHelpEntry(self::NAME, 'all', 'display all available information');
        Utils::showHelpEntry(self::NAME, 'version', 'display software version');
        Utils::showHelpEntry(self::NAME, 'copyright', 'display copyright information');
        Utils::showHelpEntry(self::NAME, 'license', 'display license information');
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
        return Utils::colorise('Version 0.4.0-dev' . PHP_EOL, Utils::COLOR_LIGHT_GREY);
    }

    /**
     * Copyright information
     *
     * @return string
     */
    public function copyright()
    {
        return Utils::colorise('Copyright (c) 2010 - ' . date('Y') . ' Phil Bayfield' . PHP_EOL, Utils::COLOR_LIGHT_GREY);
    }

    /**
     * License information
     *
     * @return string
     */
    public function license()
    {
        return Utils::colorise('GNU General Public License version 3' . PHP_EOL, Utils::COLOR_LIGHT_GREY);
    }

}
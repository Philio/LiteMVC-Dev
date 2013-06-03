<?php

/**
 * LiteMVC Application Framework
 *
 * Cli information module
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Cli\Module;

use LiteMVC\Cli\Utils;

class Info implements ModuleInterface
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
        $this->version();
        $this->copyright();
        $this->license();
    }

    /**
     * The current version
     *
     * @return string
     */
    public function version()
    {
        echo Utils::colorise('Version 0.4.0', Utils::COLOR_LIGHT_GREY) . PHP_EOL;
    }

    /**
     * Copyright information
     *
     * @return string
     */
    public function copyright()
    {
        echo Utils::colorise('Copyright (c) 2010 - ' . date('Y') . ' Phil Bayfield', Utils::COLOR_LIGHT_GREY) . PHP_EOL;
    }

    /**
     * License information
     *
     * @return string
     */
    public function license()
    {
        echo Utils::colorise('GNU General Public License version 3', Utils::COLOR_LIGHT_GREY) . PHP_EOL;
    }

}
<?php

/**
 * LiteMVC Application Framework
 *
 * Cli Orm module
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Cli\Module;

use LiteMVC\Cli\Utils;

class Orm implements ModuleInterface
{

    /**
     * Module name
     *
     * @var string
     */
    const NAME = 'orm';

    /**
     * Show help for the module
     */
    public function showHelp()
    {
        Utils::showHelpEntry(self::NAME, 'gen', 'generate models from database', array('<app>', '<config>'), array('<db>', '<tables>'));
    }

}
<?php

/**
 * LiteMVC Application Framework
 *
 * CLI ORM module
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0-dev
 */

namespace LiteMVC\CLI\Module;

use LiteMVC\CLI\CLI;

class ORM extends AbstractModule
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
        $this->_cli->showHelpEntry(self::NAME, 'gen', 'generate models from database', array('<app>', '<config>'), array('<db>', '<tables>'));
    }

}
<?php

/**
* LiteMVC Application Framework
*
* CLI interpreter
*
* @author Phil Bayfield
* @copyright 2010 - 2013
* @license GNU General Public License version 3
* @package LiteMVC
* @version 0.4.0-dev
*/

namespace LiteMVC\CLI;

class Utils
{

    /**
     * CLI command
     *
     * @var string
     */
    const CMD = 'LiteMVC';

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
     * Indent for command description
     *
     * @var int
     */
    const DESC_INDENT = 50;

    /**
     * Apply BASH color codes to some text
     *
     * @param type $text
     * @param type $color
     */
    public static function colorise($text, $color)
    {
        return $color . $text . self::COLOR_TERMINATOR;
    }

    /**
     * A large ASCII logo
     *
     * @return string
     */
    public static function logo()
    {
        return ' _     _ _       __  ____     ______' . PHP_EOL .
        '| |   (_) |_ ___|  \/  \ \   / / ___|' . PHP_EOL .
        '| |   | | __/ _ \ |\/| |\ \ / / |' . PHP_EOL .
        '| |___| | ||  __/ |  | | \ V /| |___' . PHP_EOL .
        '|_____|_|\__\___|_|  |_|  \_/  \____|' . PHP_EOL . PHP_EOL;
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
    public static function showHelpEntry($moduleName, $actionName, $desc = null, array $reqParams = array(), array $optParams = array())
    {
        // Merge all required params
        $req = array_merge(array(self::CMD, $moduleName, $actionName), $reqParams);

        // Show required params in green
        $reqFmt = count($optParams) ? '%s' : '%-' . self::DESC_INDENT . 's';
        echo self::colorise(sprintf($reqFmt, implode(' ', $req)), self::COLOR_LIGHT_GREEN);

        // Show optional params in cyan
        if (count($optParams)) {
            $optFmt = strlen(implode(' ', $req) . ' ') < self::DESC_INDENT ? '%-' . (self::DESC_INDENT - strlen(implode(' ', $req) . ' ')) . 's' : '%s';
            echo ' ' . self::colorise(sprintf($optFmt, implode(' ', $optParams)), self::COLOR_LIGHT_CYAN);
        }

        // Show description in white
        if ($desc) {
            echo ' ' . self::colorise($desc, self::COLOR_WHITE);
        }

        echo PHP_EOL . PHP_EOL;
    }


}
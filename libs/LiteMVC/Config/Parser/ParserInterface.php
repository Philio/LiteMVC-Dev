<?php

/**
 * LiteMVC Application Framework
 *
 * Parser interface
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Config\Parser;

interface ParserInterface
{

    /**
     * Parse configuration from file
     *
     * @param string $file
     * @return array
     */
    public function parse($file, $environment = null);
}

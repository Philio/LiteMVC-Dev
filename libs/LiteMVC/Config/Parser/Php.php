<?php

/**
 * LiteMVC Application Framework
 *
 * Php Parser
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Config\Parser;

use LiteMVC\Config\Exception;

class Php implements ParserInterface
{

    /**
     * Parse configuration from file
     *
     * @param string $file
     * @param string|null $environment
     * @return array
     * @throws Exception
     */
    public function parse($file, $environment = null)
    {
        // Read file
        $data = require($file);

        // If no environment, return everything
        if ($environment === null) {
            return $data;
        }

        // Otherwise, check environment exists and return it
        if (!isset($data[$environment])) {
            throw new Exception('Environment not found');
        }
        return $data[$environment];
    }

}

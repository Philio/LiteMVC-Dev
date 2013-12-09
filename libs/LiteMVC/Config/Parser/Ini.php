<?php

/**
 * LiteMVC Application Framework
 *
 * Ini Parser
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Config\Parser;

use LiteMVC\Config\Exception;

class Ini implements ParserInterface
{

    // Separators
    const SECTION_SEPARATOR = ':';
    const ITEM_SEPARATOR = '.';

    /**
     * Parse configuration from file
     *
     * @param string $file
     * @return array
     */
    public function parse($file, $environment = null)
    {
        // Load data and parse ir
        $ini = parse_ini_file($file, true);
        return $this->_parseIni($ini, $environment);
    }

    /**
     * Process the ini data
     *
     * @param array $ini
     * @param string $environment
     */
    protected function _parseIni($ini, $environment)
    {
        // If no environment
        if ($environment === null) {
            return $this->_parseEnvironment($ini);
        }

        // Check if section exists
        if (isset($ini[$environment])) {
            return $this->_parseEnvironment($ini[$environment]);
        }

        // Otherwise look and check for sections with extends
        foreach ($ini as $key => $value) {
            // If separator found split and check
            if (strpos($key, self::SECTION_SEPARATOR) !== false) {
                $parts = explode(self::SECTION_SEPARATOR, $key, 2);
                // Check for section with extend
                if (trim($parts[0]) == $environment) {
                    if (strpos($parts[1], self::SECTION_SEPARATOR) !== false) {
                        throw new Exception('An environment can not extend multiple other environments');
                    }
                    return $this->_arrayMerge(
                        $this->_parseIni($ini, trim($parts[1])),
                        $this->_parseEnvironment($value)
                    );
                }
            }
        }

        throw new Exception('Environment not found');
    }

    /**
     * Process a section of the ini file
     *
     * @param array $data
     */
    protected function _parseEnvironment($data)
    {
        $config = array();
        foreach ($data as $key => $value) {
            $config = $this->_parseKey($config, $key, $value);
        }
        return $config;
    }

    /**
     * Process a key
     *
     * @param array $config
     * @param string $key
     * @param mixed $value
     */
    protected function _parseKey($config, $key, $value)
    {
        if (strpos($key, self::ITEM_SEPARATOR) !== false) {
            $parts = explode(self::ITEM_SEPARATOR, $key, 2);
            if (!isset($config[$parts[0]])) {
                $config[$parts[0]] = array();
            }
            $config[$parts[0]] = $this->_parseKey(
                $config[$parts[0]], $parts[1], $value
            );
        } else {
            $config[$key] = $value;
        }
        return $config;
    }

    /**
     * A multi dimensional array merge replacing existing keys
     *
     * @param array $arrStart
     * @param array $arrAdd
     */
    protected function _arrayMerge(array $arrStart, array $arrAdd)
    {
        // Loop through array
        foreach ($arrAdd as $key => $value) {
            // Call recursively for arrays
            if (array_key_exists($key, $arrStart) && is_array($value)) {
                $arrStart[$key] = $this->_arrayMerge($arrStart[$key], $value);
            } else {
                $arrStart[$key] = $value;
            }
        }
        // Return merged array
        return $arrStart;
    }

}
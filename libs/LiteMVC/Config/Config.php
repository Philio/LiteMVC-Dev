<?php

/**
 * LiteMVC Application Framework
 *
 * Config parser
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Config;

use LiteMVC\Resource;

class Config extends Resource\AbstractDataset
{

    // Configuration types
    const TYPE_AUTO_EXT = 0;
    const TYPE_PHP = 1;
    const TYPE_INI = 2;

    // Supported extensions
    const EXT_PHP = 'php';
    const EXT_INI = 'ini';

    /**
     * Load configuration from a file
     *
     * @param $file
     * @param $environment
     * @param int $type
     * @throws Exception
     */
    public function load($file, $environment = null, $type = self::TYPE_AUTO_EXT)
    {
        // Check file exists
        if (!file_exists($file)) {
            throw new Exception('File not found');
        }

        // Resolve file type if auto selected
        if ($type == self::TYPE_AUTO_EXT) {
            $ext = strtolower(substr($file, strpos($file, '.') + 1));
            switch ($ext) {
                case self::EXT_PHP:
                    $type = self::TYPE_PHP;
                    break;
                case self::EXT_INI:
                    $type = self::TYPE_INI;
                    break;
            }
        }

        // Load appropriate parser or throw exception
        switch ($type) {
            case self::TYPE_PHP:
                $parser = new Parser\PhpParser();
                $this->_data = $parser->parse($file, $environment);
                break;
            case self::TYPE_INI:
                $parser = new Parser\IniParser();
                $this->_data = $parser->parse($file, $environment);
                break;
            default:
                throw new Exception('Unknown file type');
        }
    }

}

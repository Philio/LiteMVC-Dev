<?php

/**
 * LiteMVC Application Framework
 * 
 * Base resource class
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0-dev
 */

namespace LiteMVC\Resource;

abstract class AbstractResource {
    
    /**
     * Resource configuration
     *
     * @var array
     */
    protected $_config;
    
    /**
     * Configure resource
     * 
     * @param array $config
     */
    public function __construct($config = null) {
        $this->_config = $config;
    }
    
}
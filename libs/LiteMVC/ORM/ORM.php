<?php

/**
 * LiteMVC Application Framework
 * 
 * ORM
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0-dev
 */

namespace LiteMVC\ORM;

class ORM {

    /**
     * Column data types
     * 
     * @var int
     */

    const COL_INTEGER = 0;
    const COL_STRING = 1;

    /**
     * Key types
     * 
     * @var int
     */
    const KEY_PRIMARY = 0;
    const KEY_FOREIGN = 1;

}
<?php

/**
 * LiteMVC Application Framework
 *
 * Dummy test model
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0-dev
 */

namespace LiteMVCTest\Model\TestAssets;

use LiteMVC\Model;

class TestModel extends Model\AbstractModel
{

    /**
     * Database name
     *
     * @var string
     */
    protected $_database = 'a_database';

    /**
     * Table name
     *
     * @var string
     */
    protected $_table = 'a_table';

}
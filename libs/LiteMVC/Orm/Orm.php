<?php

/**
 * LiteMVC Application Framework
 *
 * Orm
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm;

use LiteMVC\Db\Driver\Factory;
use LiteMVC\Model\AbstractModel;
use LiteMVC\Orm\Query\Select;
use LiteMVC\Resource;

class Orm extends Resource\AbstractResource
{

    /**
     * Column data types
     *
     * @var int
     */
    const COL_STRING = 0;
    const COL_NUMERIC = 1;

    /**
     * Key types
     *
     * @var int
     */
    const KEY_PRIMARY = 0;
    const KEY_FOREIGN = 1;

    /**
     * Table relationship types
     *
     * @var int
     */
    const REL_PARENT = 0;
    const REL_CHILD = 1;

    /**
     * Database access modes
     *
     * @var int
     */
    const ACCESS_READ = 1;
    const ACCESS_WRITE = 2;

}

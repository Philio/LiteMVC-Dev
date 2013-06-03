<?php

/**
 * LiteMVC Application Framework
 *
 * Abstract driver for Orm
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm\Driver;

use LiteMVC\Resource\AbstractResource;
use LiteMVC\Orm\Driver\Exception;

abstract class AbstractDriver extends AbstractResource
{

    /**
     * Connection to the database
     *
     * @throws \LiteMVC\Orm\Driver\Exception
     */
    protected $_connection;

    /**
     * Connect to the database
     *
     * @return void
     */
    abstract public function connect();

    /**
     * Disconnect from the database
     *
     * @throws \LiteMVC\Orm\Driver\Exception
     */
    abstract public function disconnect();

}
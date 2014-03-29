<?php

/**
 * LiteMVC Application Framework
 *
 * PDO Connection tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Db\Driver\Pdo;

use LiteMVC\Db\Driver\Pdo\Connection;

class ConnectionTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $connection = new Connection('sqlite::memory:', 'user', 'pass', null);
        $this->assertAttributeEquals('sqlite::memory:', '_dsn', $connection);
        $this->assertAttributeEquals('user', '_username', $connection);
        $this->assertAttributeEquals('pass', '_password', $connection);
        $this->assertAttributeEquals(null, '_options', $connection);
    }

    public function testConnectInvalid()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        $connection = new Connection(null);
        $connection->connect();
    }

    public function testIsConnected()
    {
        $connection = new Connection(null);
        $this->assertFalse($connection->isConnected());
    }

    public function testInTransaction()
    {
        $connection = new Connection('sqlite::memory:');
        $this->assertFalse($connection->inTransaction());
    }

    public function testCommit()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        $connection = new Connection('sqlite::memory:');
        $connection->commit();
    }

    public function testRollback()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        $connection = new Connection('sqlite::memory:');
        $connection->rollback();
    }

}
 
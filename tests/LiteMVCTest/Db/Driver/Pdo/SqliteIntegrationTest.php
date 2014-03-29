<?php

/**
 * LiteMVC Application Framework
 *
 * Connection tests using SQLite
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Db\Driver\Pdo;

use LiteMVC\Db\Driver\Pdo\Connection;
use LiteMVC\Db\Driver\Pdo\Sqlite;

class SqliteIntegrationTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Check that PDO + SQLite are installed
     */
    public function setUp()
    {
        if (!extension_loaded('PDO')) {
            $this->markTestSkipped('PDO is not installed.');
        }
        if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
            $this->markTestSkipped('SQLite driver is not installed');
        }
    }

    public function getDriver()
    {
        return new Sqlite(array('version' => 3, 'path' => ':memory:'));
    }

    public function getConnection()
    {
        return $this->getDriver()->getConnection();
    }

    public function testConnect()
    {
        $connection = $this->getConnection();
        $this->assertSame($connection, $connection->connect());
    }

    public function testIsConnected()
    {
        $connection = $this->getConnection();
        $connection->connect();
        $this->assertTrue($connection->isConnected());
    }

    public function testDisconnect()
    {
        $connection = $this->getConnection();
        $connection->connect();
        $this->assertSame($connection, $connection->disconnect());
        $this->assertFalse($connection->isConnected());
    }

    public function testPrepare()
    {
        $connection = $this->getConnection();
        $statement = $connection->prepare("SELECT 1");
        $this->assertInstanceOf('LiteMVC\Db\Driver\Statement', $statement);
    }

    public function testPrepareBadQuery()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        $connection = $this->getConnection();
        $connection->prepare("SELECT 1 FROM made_up_table");
    }

    public function testQuery()
    {
        $connection = $this->getConnection();
        $statement = $connection->query("SELECT 1");
        $this->assertInstanceOf('LiteMVC\Db\Driver\Statement', $statement);
    }

    public function testQueryBadQuery()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        $connection = $this->getConnection();
        $connection->query("SELECT 1 FROM made_up_table");
    }

    public function testExec()
    {
        $connection = $this->getConnection();
        $affectedRows = $connection->exec("SELECT 1");
        $this->assertEquals(0, $affectedRows);
    }

    public function testExecBadQuery()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        $connection = $this->getConnection();
        $connection->exec("SELECT 1 FROM made_up_table");
    }

    public function testLastInsertId()
    {
        $connection = $this->getConnection();
        $connection->exec("CREATE TABLE test (id INTEGER PRIMARY KEY)");
        $connection->exec("INSERT INTO test VALUES (1)");
        $this->assertEquals(1, $connection->lastInsertId());
    }

    public function testBeginTransaction()
    {
        $connection = $this->getConnection();
        $this->assertTrue($connection->beginTransaction());
    }

    public function testBeginTransactionInTransaction()
    {
        $connection = $this->getConnection();
        $this->assertTrue($connection->beginTransaction());
        $this->assertFalse($connection->beginTransaction());
    }

    public function testInTransaction()
    {
        $connection = $this->getConnection();
        $this->assertFalse($connection->inTransaction());
        $this->assertTrue($connection->beginTransaction());
        $this->assertTrue($connection->inTransaction());
    }

    public function testCommit()
    {
        $connection = $this->getConnection();
        $connection->connect();
        $this->assertTrue($connection->beginTransaction());
        $this->assertTrue($connection->commit());
        $this->assertFalse($connection->inTransaction());
    }

    public function testCommitNotInTransaction()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        $connection = $this->getConnection();
        $connection->connect();
        $connection->commit();
    }

    public function testRollback()
    {
        $connection = $this->getConnection();
        $connection->connect();
        $this->assertTrue($connection->beginTransaction());
        $this->assertTrue($connection->rollback());
        $this->assertFalse($connection->inTransaction());
    }

    public function testRollbackNotInTransaction()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        $connection = $this->getConnection();
        $connection->connect();
        $connection->rollback();
    }

}
 
<?php

/**
 * LiteMVC Application Framework
 *
 * Statement tests using SQLite
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Db\Driver\Pdo;

use LiteMVC\Db\Driver\Pdo\Sqlite;

class SqliteStatementIntegrationTest extends \PHPUnit_Framework_TestCase
{

    private $_create =
        "CREATE TABLE test (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            test_int INTEGER,
            test_real REAL,
            test_text TEXT
        )";

    private $_data = array(
        array('id' => '1', 'test_int' => '123', 'test_real' => '123.456', 'test_text' => 'Test Text'),
        array('id' => '2', 'test_int' => '456', 'test_real' => '456.789', 'test_text' => 'Some Other Text'),
    );

    /**
     * @var Connection
     */
    private $_connection;

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

        // Create a table in a known state
        $sqlite = new Sqlite(array('version' => 3, 'path' => ':memory:'));
        $connection = $sqlite->getConnection();
        $connection->exec($this->_create);
        foreach ($this->_data as $row) {
            $connection->exec(sprintf("INSERT INTO test VALUES(%s, %s, %s, '%s')", $row['id'], $row['test_int'],
                $row['test_real'], $row['test_text']));
        }
        $this->_connection = $connection;
    }

    public function testBindParam()
    {
        $statement = $this->_connection->prepare("UPDATE test SET test_text = ? WHERE id = 1");
        $variable = 'Some new test text';
        $this->assertTrue($statement->bindParam(1, $variable));
    }

    public function testBindValue()
    {
        $statement = $this->_connection->prepare("UPDATE test SET test_text = ? WHERE id = 1");
        $variable = 'Some new test text';
        $this->assertTrue($statement->bindValue(1, $variable));
    }

    public function testExecute()
    {
        $statement = $this->_connection->prepare("UPDATE test SET test_text = 'Some new test text' WHERE id = 1");
        $this->assertTrue($statement->execute());
    }

    public function testExecuteParams()
    {
        $statement = $this->_connection->prepare("UPDATE test SET test_text = ? WHERE id = 1");
        $this->assertTrue($statement->execute(array('Some new test text')));
    }

    public function testExecuteWrongParamCount()
    {
        $this->setExpectedException('LiteMVC\Db\Driver\Exception');
        $statement = $this->_connection->prepare("UPDATE test SET test_text = ? WHERE id = 1");
        $statement->execute(array('Some new test text', 'Some more new test text'));
    }

    public function testRowCountUpdate()
    {
        $statement = $this->_connection->query("UPDATE test SET test_text = 'Some new test text' WHERE id = 1");
        $this->assertEquals(1, $statement->rowCount());
    }
    public function testRowCountInsert()
    {
        $statement = $this->_connection->query("INSERT INTO test VALUES (null, 321, 321.123, 'Insert test')");
        $this->assertEquals(1, $statement->rowCount());
    }

    public function testRowCountDelete()
    {
        $statement = $this->_connection->query("DELETE FROM test");
        $this->assertEquals(2, $statement->rowCount());
    }

    public function testColumnCount()
    {
        $statement = $this->_connection->query("SELECT * FROM test");
        $this->assertEquals(4, $statement->columnCount());
    }

    public function testFetch() {
        $statement = $this->_connection->query("SELECT * FROM test");
        $this->assertEquals($this->_data[0], $statement->fetch());
        $this->assertEquals($this->_data[1], $statement->fetch());
        $this->assertFalse($statement->fetch());
    }

    public function testFetchAll()
    {
        $statement = $this->_connection->query("SELECT * FROM test");
        $this->assertEquals($this->_data, $statement->fetchAll());
    }

    public function testCloseCursor()
    {
        $statement = $this->_connection->query("SELECT * FROM test");
        $this->assertTrue($statement->closeCursor());
    }

    public function testUpdate()
    {
        $statement = $this->_connection->prepare("UPDATE test SET test_text = ? WHERE id = 1");
        $this->assertTrue($statement->execute(array('Some new test text')));
        $queryStatement = $this->_connection->query("SELECT test_text FROM test WHERE id = 1");
        $data = $queryStatement->fetch();
        $this->assertEquals('Some new test text', $data['test_text']);
    }

    public function testUpdateBindParam()
    {
        $statement = $this->_connection->prepare("UPDATE test SET test_text = ? WHERE id = 1");
        $variable = 'Some new test text';
        $this->assertTrue($statement->bindParam(1, $variable));
        $variable = 'Some edited test text';
        $this->assertTrue($statement->execute());
        $queryStatement = $this->_connection->query("SELECT test_text FROM test WHERE id = 1");
        $data = $queryStatement->fetch();
        $this->assertEquals($variable, $data['test_text']);
    }

    public function testUpdateBindValue()
    {
        $statement = $this->_connection->prepare("UPDATE test SET test_text = ? WHERE id = 1");
        $this->assertTrue($statement->bindValue(1, 'Some new test text'));
        $this->assertTrue($statement->execute());
        $queryStatement = $this->_connection->query("SELECT test_text FROM test WHERE id = 1");
        $data = $queryStatement->fetch();
        $this->assertEquals('Some new test text', $data['test_text']);
    }

}
 
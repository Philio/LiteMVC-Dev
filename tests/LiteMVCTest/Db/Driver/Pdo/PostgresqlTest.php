<?php

/**
 * LiteMVC Application Framework
 *
 * PostgreSQL driver tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Db\Driver\Pdo;

use LiteMVC\Db\Driver\Pdo\Postgresql;

class PostgresqlTest extends \PHPUnit_Framework_TestCase
{

    private $_config = array(
        'port' => 5432,
        'username' => 'test',
        'password' => 'testing',
        'dbname' => 'testdb'
    );

    /**
     * Check that PDO + Postgres are installed
     */
    public function setUp()
    {
        if (!extension_loaded('PDO')) {
            $this->markTestSkipped('PDO is not installed.');
        }
        if (!in_array('pgsql', \PDO::getAvailableDrivers())) {
            $this->markTestSkipped('Postgres driver is not installed');
        }
    }

    public function testIsAvailable()
    {
        $postgres = new Postgresql();

        $this->assertTrue($postgres->isAvailable());
    }

    public function testGetName()
    {
        $postgres = new Postgresql();

        $this->assertEquals('pdo_pgsql', $postgres->getName());
    }

    public function testGetDsn()
    {
        $postgres = new Postgresql();
        $postgres->setConfig($this->_config);

        $this->assertEquals('pgsql:host=localhost;port=5432;dbname=testdb;user=test;password=testing',
            $postgres->getDsn());
    }

}
 
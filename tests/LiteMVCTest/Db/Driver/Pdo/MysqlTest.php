<?php

/**
 * LiteMVC Application Framework
 *
 * MySQL driver tests
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Db\Driver\Pdo;

use LiteMVC\Db\Driver\Pdo\Mysql;

class MysqlTest extends \PHPUnit_Framework_TestCase
{

    private $_configPortDbname = array(
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'test'
    );

    private $_configSocketCharset = array(
        'unix_socket' => '/var/lib/mysql/mysql.sock',
        'charset' => 'UTF8'
    );

    /**
     * Check that PDO + MySQL are installed
     */
    public function setUp()
    {
        if (!extension_loaded('PDO')) {
            $this->markTestSkipped('PDO is not installed.');
        }
        if (!in_array('mysql', \PDO::getAvailableDrivers())) {
            $this->markTestSkipped('MySQL driver is not installed');
        }
    }

    public function testIsAvailable()
    {
        $mysql = new Mysql();

        $this->assertTrue($mysql->isAvailable());
    }

    public function testGetName()
    {
        $mysql = new Mysql();

        $this->assertEquals('pdo_mysql', $mysql->getName());
    }

    public function testGetDsnPortDbname()
    {
        $mysql = new Mysql();
        $mysql->setConfig($this->_configPortDbname);

        $this->assertEquals('mysql:host=localhost;port=3306;dbname=test', $mysql->getDsn());
    }

    public function testGetDsnSocketCharset()
    {
        $mysql = new Mysql();
        $mysql->setConfig($this->_configSocketCharset);

        $this->assertEquals('mysql:host=localhost;unix_socket=/var/lib/mysql/mysql.sock;charset=UTF8', $mysql->getDsn());
    }

    public function testGetOptions()
    {
        $mysql = new Mysql();

        $this->assertEquals(array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'), $mysql->getOptions());
    }

}
 
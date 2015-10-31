<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 29/10/15
 * Time: 10:43 AM
 */

namespace Database;


use Core\Database\Connection;

class ConnectionTest extends \PHPUnit_Extensions_Database_TestCase
{
    private static $pdo = null;
    private $conn = null;
    public $conf;

    public function getConnection()
    {
        if ($this->conn === null) {
            $this->conf = $conf = require(_ROOT . '/config/db.conf.php');

            if (self::$pdo == null) {
                self::$pdo = new Connection($conf);
            }

            $this->conn = $this->createDefaultDBConnection(self::$pdo, 'test');
        }

        return $this->conn;
    }

    public function getDataSet()
    {
        return $this->createMySQLXMLDataSet(__DIR__ . "/Fixtures/testDBFixture.xml");
    }

    public function getSetUpOperation() {
        return $this->getOperations()->CLEAN_INSERT();
    }

    public function testDatabaseHasUser()
    {
        $this->getConnection()->createDataSet(array('user'));
        $prod = $this->getDataSet();
        $resultingTable = $this->getConnection()->createQueryTable('user', 'SELECT * FROM user');
        $expectedTable = $this->getDataSet()->getTable('user');

        $this->assertTablesEqual($expectedTable, $resultingTable);
    }
}

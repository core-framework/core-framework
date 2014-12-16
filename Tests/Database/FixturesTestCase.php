<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 27/11/14
 * Time: 10:24 AM
 */

namespace Core\Tests\Database;

use Core\Database\Database;

class FixturesTestCase extends \PHPUnit_Extensions_Database_TestCase {

    public $fixtures = ['post', 'postmeta', 'options'];

    private $connection = null;

    public function setUp() {
        $conn = $this->getConnection();
        $pdo = $conn->getConnection();

        // set up tables
        $fixtureDataSet = $this->getDataSet($this->fixtures);
        foreach ($fixtureDataSet->getTableNames() as $table) {
            // drop table
            $pdo->exec("DROP TABLE IF EXISTS '$table';");
            // recreate table
            $meta = $fixtureDataSet->getTableMetaData($table);
            $create = "CREATE TABLE IF NOT EXISTS '$table';";
            $cols = array();
            foreach ($meta->getColumns() as $col) {
                $cols[] = "'$col' VARCHAR(200)";
            }
            $create .= '('.implode(',', $cols).');';
            $pdo->exec($create);
        }

        parent::setUp();
    }

    public function tearDown() {
        $allTables =
            $this->getDataSet($this->fixtures)->getTableNames();
        foreach ($allTables as $table) {
            // drop table
            $conn = $this->getConnection();
            $pdo = $conn->getConnection();
            $pdo->exec("DROP TABLE IF EXISTS '$table';");
        }

        parent::tearDown();
    }

    public function getConnection() {
        if ($this->connection === null) {
            try {
                $pdo = new Database(['type' => 'mysql', 'host' => 'localhost', 'user' => 'root', 'password' => 'qwedsa', 'dbname' => 'test' ]);
                $this->connection = $this->createDefaultDBConnection($pdo, 'test');
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
        return $this->connection;
    }

    public function getDataSet($fixtures = array()) {
        if (empty($fixtures)) {
            $fixtures = $this->fixtures;
        }
        $compositeDs = new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet(array());
        $fixturePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'fixtures';

        foreach ($fixtures as $fixture) {
            $path =  $fixturePath . DIRECTORY_SEPARATOR . "$fixture.xml";
            $ds = $this->createMySQLXMLDataSet($path);
            $compositeDs->addDataSet($ds);
        }
        return $compositeDs;
    }

    public function loadDataSet($dataSet) {
        // set the new dataset
        $this->getDatabaseTester()->setDataSet($dataSet);
        // call setUp whateverhich adds the rows
        $this->getDatabaseTester()->onSetUp();
    }
} 
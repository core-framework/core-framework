<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 25/11/14
 * Time: 7:25 PM
 */

namespace Core\Tests\Database;


class DatabaseTest extends FixturesTestCase {

    public $fixtures = array(
        'posts',
        'postmeta',
        'options'
    );

    function testReadDatabase() {
        $conn = $this->getConnection()->getConnection();

        // fixtures auto loaded, let's read some data
        $query = $conn->query('SELECT * FROM posts');
        $results = $query->fetchAll(PDO::FETCH_COLUMN);
        $this->assertEquals(2, count($results));

        // now delete them
        $conn->query('TRUNCATE posts');

        $query = $conn->query('SELECT * FROM posts');
        $results = $query->fetchAll(PDO::FETCH_COLUMN);
        $this->assertEquals(0, count($results));

        // now reload them
        $ds = $this->getDataSet(array('posts'));
        $this->loadDataSet($ds);

        $query = $conn->query('SELECT * FROM posts');
        $results = $query->fetchAll(PDO::FETCH_COLUMN);
        $this->assertEquals(2, count($results));
    }

} 

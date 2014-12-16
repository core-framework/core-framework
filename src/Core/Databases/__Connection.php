<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 25/11/14
 * Time: 3:56 PM
 */

namespace Core\Databases;

use PDO;

class Connection extends PDO {

    protected $connection;

    public function __construct ($array = [])
    {
        if(empty($array)) {
            throw new \ErrorException("Connection parameters cannot be empty.");
        }

        if ($array['db'] == "") {
            $db = "";
        } elseif ($array['db'] != null) {
            $db = "dbname=" . $array['db'];
        }

        if (!empty($array['type'])) {
            $type = $array['type'];
        } else {
            $type = "mysql";
        }

        if (!empty($array['host'])) {
            $host = $array['host'];
        } else {
            throw new \Exception("Database Host not provided.");
        }

        if (!empty($array['username'])) {
            $user = $array['username'];
        } else {
            $user = null;
        }

        if (!empty($array['password'])) {
            $pass = $array['password'];
        } else {
            $pass = null;
        }

        if (!empty($array['port'])) {
            $port = "port=" . $array['port'];
        } else {
            $port = "";
        }

        $dsn = $type . ':' . $db . ';' . 'host=' . $host . ';' . $port;

        $dsnString = $dsn;

        if (isset($array['dsn'])) {
            $dsn = $array['type'] . ":";
            $dsnAttrArr = [];
            foreach($array['dsn'] as $key => $val) {
                $dsnAttrArr[] = $key . "=" . $val;
            }

            $dsnAttr = implode(";", $dsnAttrArr);

            $dsnString = $dsn . $dsnAttr;
        }

        return $this->connection = parent::__construct($dsnString, $user, $pass);
    }

    public function getInstance()
    {
        return $this->connection;
    }

} 

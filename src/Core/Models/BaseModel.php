<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 28/06/15
 * Time: 12:59 AM
 */

namespace Core\Models;


use Core\Database\Connection;
use Core\DI\DI;

abstract class BaseModel {

    /**
    * @var string Database table name
    */
    protected static $tableName = '';
    /**
     * @var string Table primary key
     */
    protected static $primaryKey = '';
    /**
     * @var string Database name
     */
    protected static $dbName = '';
    /**
     * @var Connection database object instance
     */
    protected static $connection;

    protected static $dbConf = [];

    public static $columnFillBlacklist = [];

    public static $columnSaveBlacklist = [];

    abstract public function save();

    abstract public function update();

    abstract public function beforeSave();

    abstract public function __construct(array $columns = [], Connection $connection = null);

    public static function getConnection(array $dbConf = [])
    {
        if (empty($dbConf) && empty(static::$dbConf)) {
            /** @var \Core\Config\AppConfig $config */
            $config = DI::get('Config');
            $dbConf = $config->get('$db');
        } elseif (empty($dbConf) && !empty(static::$dbConf)) {
            $dbConf = static::$dbConf;
        }

        $arr[] = [];
        $arr['db'] = isset(static::$dbName) && empty(static::$dbName) === false ? static::$dbName : $dbConf['db'];
        $arr['type'] = isset($dbConf['pdoDriver']) ? $dbConf['pdoDriver'] : '';
        $arr['host'] = isset($dbConf['host']) ? $dbConf['host'] : '';
        $arr['user'] = isset($dbConf['user']) ? $dbConf['user'] : '';
        $arr['pass'] = isset($dbConf['pass']) ? $dbConf['pass'] : '';
        $arr['port'] = isset($dbConf['port']) ? $dbConf['port'] : '';

        return new Connection($arr);
    }

    public static function setDbConf(array $conf)
    {
        static::$dbConf = $conf;
    }

    public static function addDbConf($key, $val)
    {
        static::$dbConf[$key] = $val;
    }

    public static function configure($object, $props)
    {
        foreach ($props as $name => $value) {
            if (!in_array($name, static::$columnFillBlacklist)) {
                $object->$name = $value;
            }
        }

        return $object;
    }

    /**
     * Executes a simple 'SELECT * (all columns)' statement with parameters provided
     *
     * @param array $conditions
     * @param null $orderBy
     * @param null $order
     * @param null $startIndex
     * @param null $count
     * @param $asArray
     *
     * @return array
     */
    static function getAllRows(
        $conditions = [],
        $orderBy = null,
        $order = null,
        $startIndex = null,
        $count = null,
        $asArray = false
    ) {
        $query = "SELECT * FROM " . static::$tableName;
        $params = [];
        if (!empty($conditions)) {
            $query .= " WHERE ";
            foreach ($conditions as $key => $val) {
                $query .= $key . "=:" . $key . " AND ";
                $params[':' . $key] = $val;
            }
        }
        $query = rtrim($query, ' AND ');
        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $orderBy;
            $query .= " " . $order;
        }
        if (!is_null($startIndex) && !is_null($count)) {
            $query .= " LIMIT " . $startIndex;
            if (!empty($query)) {
                $query .= "," . $count;
            }
        }
        if ($asArray === false) {
            return self::get($query, $params);
        } else {
            return self::getAsArray($query, $params);
        }
    }


    /**
     * Returns a collection of rows for the given query
     *
     * @param $query
     * @param array $params
     * @return array
     */
    public static function get($query, $params = [])
    {
        $prep = self::$connection->getPrepared($query);
        $prep->execute($params);
        $result = $prep->fetchAll(\PDO::FETCH_ASSOC);
        $collection = [];
        $className = get_called_class();
        foreach ($result as $row) {
            $item = new $className();
            $item->getPropFromDb($row);
            array_push($collection, $item);
        }
        return $collection;
    }

    /**
     * Returns rows as array instead of objects
     *
     * @param $query
     * @param array $params
     * @return array
     */
    public static function getAsArray($query, $params = [])
    {
        $prep = self::$connection->getPrepared($query);
        $prep->execute($params);
        $result = $prep->fetchAll(\PDO::FETCH_ASSOC);
        $collection = [];
        foreach ($result as $row) {
            array_push($collection, $row);
        }
        return $collection;
    }


    /**
     * Outputs one row based on the primary key provided
     *
     * @param $value
     * @return mixed
     */
    public static function getByPrimaryKey($value)
    {
        $prop = [];
        $prop[static::$primaryKey] = $value;
        return self::getOneRow($prop);
    }

    /**
     * Returns one row based on the provided condition
     *
     * @param array $conditions
     * @return mixed
     */
    public static function getOneRow(array $conditions)
    {
        $query = "SELECT * FROM " . static::$tableName;
        $params = [];
        if (!empty($conditions)) {
            $query .= " WHERE ";
            foreach ($conditions as $key => $val) {
                $query .= $key . "=:" . $key . " AND ";
                $params[":" . $key] = $val;
            }
        }
        $query = rtrim($query, ' AND ');
        return self::getFromDbandBuildObj($query, $params);
    }

    /**
     * Returns an object of the class that calls this function, filled with values from the database, based on the query provided
     *
     * @param $query
     * @param array $params
     * @return mixed
     */
    private static function getFromDbandBuildObj($query, $params = [])
    {
        $prep = self::$connection->getPrepared($query);
        $prep->execute($params);
        $row = $prep->fetch(\PDO::FETCH_ASSOC);
        $className = get_called_class();
        $obj = new $className();
        if ($row !== false) {
            $obj->getPropFromDb($row);
            return $obj;
        } else {
            return false;
        }


    }

    /**
     * Returns count of rows according to the parameters provided
     *
     * @param array $conditions
     * @return mixed
     */
    public static function getCount(array $conditions)
    {
        $query = "SELECT COUNT(*) FROM " . static::$tableName;
        $params = [];
        if (!empty($conditions)) {
            $query .= " WHERE ";
            foreach ($conditions as $key => $val) {
                $query .= $key . "=:" . $key . " AND ";
                $params[":" . $key] = $val;
            }
        }
        $query = rtrim($query, ' AND ');
        return self::getFromDb($query, $conditions);
    }

    /**
     * Gets the query result from Database
     *
     * @param $query
     * @param array $params
     * @return mixed
     */
    public static function getFromDb($query, array $params)
    {
        $db = self::$connection;
        $prep = $db->getPrepared($query);
        $prep->execute($params);
        $arr = $prep->fetch();
        return $arr[0];
    }

    /**
     * Simply fills the $prop array with properties from a given array
     *
     * @param array $prop
     */
    public function getPropFromDb(array $prop)
    {
        foreach ($prop as $key => $val) {
            $this->$key = $val;
        }
    }


     /**
     * @return Connection
     */
    public static function getDb()
    {
        return self::$connection;
    }

    /**
     * @param Connection $db
     */
    public static function setDb($db)
    {
        self::$connection = $db;
    }

    /**
     * @return string
     */
    public static function getTableName()
    {
        return self::$tableName;
    }

    /**
     * @param string $tableName
     */
    public static function setTableName($tableName)
    {
        self::$tableName = $tableName;
    }

    /**
     * @return string
     */
    public static function getPrimaryKey()
    {
        return self::$primaryKey;
    }

    /**
     * @param string $primaryKey
     */
    public static function setPrimaryKey($primaryKey)
    {
        self::$primaryKey = $primaryKey;
    }

    /**
     * @return string
     */
    public static function getDbName()
    {
        return self::$dbName;
    }

    /**
     * @param string $dbName
     */
    public static function setDbName($dbName)
    {
        self::$dbName = $dbName;
    }
}
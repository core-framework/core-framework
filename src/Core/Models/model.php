<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Models;

use Core\Databases\database;

/**
 * @author Shalom Sam <shalom.s@coreframework.in>
 * Class model
 * @package Core\Models
 */
class model {

    protected $db;
    protected static $tableName = '';
    protected static $primaryKey = '';
    protected $props = [];

    public function __construct(){

    }

    public function setProps($param, $val){
        $this->props[$param] = $val;
    }

    public function getProps($param){
        return $this->props[$param];
    }

    public function save() {
        $query =  "REPLACE INTO " . static::$tableName . " (" . implode(",", array_keys($this->props)) . ") VALUES(";
        $keys = [];
        foreach ($this->props as $key => $value) {
            $keys[":".$key] = $value;
        }
        $query .= implode(",", array_keys($keys)).")";
        $db = database::getInstance();
        $prep = $db->getPrepared($query);
        $prep->execute($keys);
    }

    public function delete() {
        $query = "DELETE FROM " . static::$tableName . " WHERE ".static::$primaryKey."=:id LIMIT 1";
        $db = database::getInstance();
        $prep = $db->getPrepared($query);
        $prep->execute(array(':id'=>$this->props[static::$primaryKey]));
    }

    public function getPropFromDb(array $prop){
        foreach($prop as $key => $val){
            //$this->$key = $val;
            $this->props[$key] = $val;
        }
    }

    public static function get($query, array $params){
        $db = database::getInstance();
        $prep = $db->getPrepared($query);
        $prep->execute($params);
        $result = $prep->fetchAll(\PDO::FETCH_ASSOC);
        $collection = [];
        $className = get_called_class();
        foreach($result as $row){
            $item = new $className();
            $item->getPropFromDb($row);
            array_push($collection, $item);
        }
        return $collection;
    }

    static function getAllRows(array $conditions, $orderBy = null, $startIndex = null, $count = null){
        $query = "SELECT * FROM " . static::$tableName;
        $params = [];
        if(!empty($conditions)){
            $query .= " WHERE ";
            foreach($conditions as $key => $val){
                $query .= $conditions[':'.$key] = $key . " AND ";
                $params[':'.$key] = $val;
            }
        }
        $query = rtrim($query, ' AND ');
        if(!empty($orderBy)){
            $query .= " ORDER BY " . $orderBy;
        }
        if(!empty($orderBy)){
            $query .= " LIMIT " . $startIndex;
            if(!empty($query)){
                $query .= "," . $count;
            }
        }
        return self::get($query, $params);

    }

    public static function getByPrimaryKey($value){
        $prop = [];
        $prop[static::$primaryKey] = $value;
        return self::getOneRow($prop);
    }

    public static function getOneRow(array $conditions){
        $query = "SELECT * FROM ". static::$tableName;
        $params = [];
        if(!empty($conditions)){
            $query .= " WHERE ";
            foreach($conditions as $key => $val){
                $query .= $key . "=:" . $key . " AND ";
                $condition[":".$key] = $val;
            }
        }
        $query = rtrim($query, ' AND ');
        return self::getFromDbandBuildObj($query, $params);
    }

    public static function getCount(array $conditions){
        $query = "SELECT COUNT(*) FROM ". static::$tableName;
        $params = [];
        if(!empty($conditions)){
            $query .= " WHERE ";
            foreach($conditions as $key => $val){
                $query .= $key . ":=" . $key . " AND ";
                $params[":".$key] = $val;
            }
        }
        $query = rtrim($query, ' AND ');
        return self::getFromDb($query, $conditions);
    }

    private function getFromDb($query, array $params){
        $db = database::getInstance();
        $prep = $db->getPrepared($query);
        $prep->execute($params);
        $arr = $prep->fetch();
        return $arr[0];
    }

    private function getFromDbandBuildObj($query, array $params){
        $db = database::getInstance();
        $prep = $db->getPrepared($query);
        $prep->execute($params);
        $row = $prep->fetch(\PDO::FETCH_ASSOC);
        $className = get_called_class();
        $obj = new $className();
        $obj->getPropFromDb($row);
        return $obj;
    }
}
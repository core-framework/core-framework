<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 02/05/15
 * Time: 4:56 PM
 */

namespace Core\Collections;


class Collection
{
    protected static $collectionName;
    protected static $dbName = '';
    protected static $conn;
    protected static $primaryKey;
    protected static $db;

    public function __construct(\MongoDB $db)
    {
        self::$db = $db;
    }

    public static function configure($object, $data)
    {
        if (!is_object($object)) {
            throw new \ErrorException('Invalid parameter given. Object expected.');
        }

        $props = get_object_vars($object);

        if (!empty($data)) {

            foreach ($props as $prop) {
                if (isset($data[$prop])) {
                    $object->$prop = $data[$prop];
                }
            }
        }

        return $object;
    }

    public static function findAll($condition = [], $orderBy = null, $limit = null)
    {
        $parameters = [];
        if (isset($condition) === true) {
            $parameters['condition'] = $condition;
        }
        if (isset($orderBy) === true) {
            $parameters['orderBy'] = $orderBy;
        }
        if (isset($limit) === true) {
            $parameters['limit'] = $limit;
        }

        return self::find($parameters);
    }

    public static function find($parameters = null)
    {
        if (is_null($parameters) === false && is_array($parameters) === false) {
            throw new \ErrorException('Invalid parameters for find');
        }

        $className = get_called_class();
        $collection = new $className();

        return self::getResultSet($parameters, $collection);
    }

    public static function getCount($condition = null)
    {
        if (is_null($condition) === false && is_array($condition) === false) {
            throw new \ErrorException('Invalid parameters for find');
        }

        $className = get_called_class();
        /** @var Collection $collection */
        $collection = new $className();
        $collectionName = $collection->getCollectionName();
        $db = $collection->getConnection();

        $mCollection = $db->$collectionName;

        if (isset($condition) === true) {
            return $mCollection->find($condition)->count();
        } else {
            return $mCollection->count();
        }
    }

    public static function aggregate($pipeline)
    {
        if (is_null($pipeline) === false && is_array($pipeline) === false) {
            throw new \ErrorException('Invalid parameters for find');
        }


        $className = get_called_class();
        /** @var Collection $collection */
        $collection = new $className();
        $collectionName = $collection->getCollectionName();
        $db = $collection->getConnection();

        $mCollection = $db->$collectionName;

        return $mCollection->aggregate($pipeline);

    }

    public static function getResultSet($parameters = null, Collection $collection)
    {
        $collectionName = $collection->getCollectionName();
        $db = $collection->getConnection();
        /** @var \MongoCollection $mCollection */
        $mCollection = $db->$collectionName;

        if (isset($parameters['condition']) === true) {
            $condition = $parameters['condition'];
        } elseif (isset($parameters['query']) === true) {
            $condition = $parameters['query'];
        } else {
            $condition = [];
        }

        if (isset($parameters['fields'])) {
            $docCursor = $mCollection->find($condition, $parameters['fields']);
        } else {
            $docCursor = $mCollection->find($condition);
        }

        if (isset ($parameters['orderBy']) === true) {
            $docCursor->sort($parameters['$orderBy']);
        }

        if (isset($parameters['limit']) === true) {
            $docCursor->limit($parameters['limit']);
        }

        $docArr = iterator_to_array($docCursor);

        if (empty($docArr)) {
            return [];
        }

        return static::createObjectFromArr($docArr);

    }

    public function getCollectionName()
    {
        if (isset($this->collectionName) === false) {
            $this->collectionName = strtolower(get_class($this));
        }

        return $this->collectionName;
    }

    public function getConnection()
    {
        self::$conn = $conn = new \MongoClient();
        $dbName = self::getDbName();

        self::$db = $db = $conn->$dbName;

        return $db;
    }

    public static function getDbName()
    {
        return static::$dbName;
    }

    public static function createObjectFromArr(array $arr)
    {
        if (empty($arr)) {
            throw new \ErrorException('Array cannot be empty in createObjectFromArr');
        }

        $collectionArr = [];
        $class = get_called_class();
        foreach ($arr as $doc) {
            $collectionArr[] = new $class($doc);
        }

        return $collectionArr;
    }

    public static function findOne($condition = null)
    {
        if (is_null($condition) === false && is_array($condition) === false) {
            throw new \ErrorException('Invalid parameters for find');
        }
        $condition['limit'] = 1;

        return static::find($condition);
    }

    public function save()
    {
        $db = $this->getConnection();
        $collectionName = $this->getCollectionName();
        $this->unsetBeforeSave();

        if (empty($collectionName)) {
            throw new \ErrorException('Collection Name not specified.');
        }

        if (!$db instanceof \MongoDB) {
            throw new \ErrorException('Database not specified.');
        }

        /** @var \MongoCollection $collection */
        $collection = $db->$collectionName;
        if ($collection->insert($this) === false) {
            throw new \ErrorException('Unable to save to database.');
        }
    }

    public function unsetBeforeSave()
    {
        unset($this->_id);
        unset($this->creation_date);
        unset($this->modified_date);
    }

    public function update($conditions = [], $fields = [])
    {
        $db = $this->getConnection();
        $collectionName = $this->getCollectionName();
        $this->unsetBeforeSave();

        if (empty($collectionName)) {
            throw new \ErrorException('Collection Name not specified.');
        }

        if (!$db instanceof \MongoDB) {
            throw new \ErrorException('Database not specified.');
        }

        if (empty($conditions) === true) {
            $primaryKey = static::$primaryKey;
            $conditions = [$primaryKey => $this->$primaryKey];
        }

        if (empty($fields) === true) {
            $fields = (array)$this;
        }

        /** @var \MongoCollection $collection */
        $collection = $db->$collectionName;
        if ($collection->update($conditions, ['$set' => $fields])) {
            throw new \ErrorException('Unable to update collection');
        }
    }

}
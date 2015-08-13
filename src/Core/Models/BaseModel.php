<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 28/06/15
 * Time: 12:59 AM
 */

namespace Core\Models;


use Core\Databases\Database;
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

    abstract public function save();

    abstract public function update();

    abstract public function beforeSave();

    abstract public function __construct($userData = []);

    public static function getConnection()
    {
        /** @var \Core\Config\Config $config */
        $config = DI::get('Config');
        $dbConf = $config['$db'];
        $arr[] = [];
        $arr['db'] = isset(self::$dbName) && empty(self::$dbName) === false ? self::$dbName : $dbConf['db'];
        $arr['type'] = isset($dbConf['pdoDriver']) ? $dbConf['pdoDriver'] : '';
        $arr['host'] = isset($dbConf['host']) ? $dbConf['host'] : '';
        $arr['username'] = isset($dbConf['user']) ? $dbConf['user'] : '';
        $arr['password'] = isset($dbConf['pass']) ? $dbConf['pass'] : '';
        $arr['port'] = isset($dbConf['port']) ? $dbConf['port'] : '';

        return new Database($arr);
    }

    public static function configure($object, $props)
    {
        foreach ($props as $name => $value) {
            $object->$name = $value;
        }

        return $object;
    }
}
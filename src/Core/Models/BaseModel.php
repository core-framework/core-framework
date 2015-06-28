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

    abstract public function unsetBeforeSave();

    abstract public function __construct($userData = []);

    public function getConnection()
    {
        /** @var \Core\Config\Config $config */
        $config = DI::get('Config');
        $dbConf = $config['$db'];
        $arr[] = [];
        $arr['db'] = isset(self::$dbName) ? self::$dbName : $dbConf['db'];
        $arr['type'] = $dbConf['pdoDriver'];
        $arr['host'] = $dbConf['host'];
        $arr['username'] = $dbConf['user'];
        $arr['password'] = $dbConf['pass'];
        $arr['port'] = $dbConf['port'];

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
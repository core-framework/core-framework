<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 18/02/15
 * Time: 8:47 PM
 */

namespace web\Models;

use Core\Database\Database;
use Core\DI\DI;
use Core\Models\Model;

class User extends Model {

    protected static $tableName = 'user';
    protected static $primaryKey = 'userId';
    protected static $dbName = 'test';

    public $fname;
    public $lname;
    public $name;
    public $userId;
    public $email;
    public $email_hash;
    public $pass_hash;
    public $salt;


    public function __construct($userData = [], $connection = null)
    {
        if (!empty($userData)) {
            self::configure($this, $userData);
            $this->createUserId();
        }

        if (is_null($connection)) {

            /** @var \Core\Config\Config $config */
            $config = DI::get('Config');
            $dbConf = $config['$db'];
            $arr[] = [];
            $arr['db'] = self::$dbName;
            $arr['type'] = 'mysql';
            $arr['host'] = $dbConf['host'];
            $arr['username'] = $dbConf['user'];
            $arr['password'] = $dbConf['pass'];
            $arr['port'] = '';

            $connection = new Database($arr);
        }

        parent::__construct($connection);
    }

    public function save()
    {
        self::checkIfUserExists($this->email);
        $this->unsetBeforeSave();
        return parent::save();
    }

    public function update()
    {
        $this->unsetBeforeSave();
        return parent::update();
    }

    private function unsetBeforeSave()
    {
        unset($this->csrf);
        unset($this->id);
        unset($this->password);
        unset($this->password_confirm);
        unset($this->register_date);
        unset($this->submitted_date);
        unset($this->modified_date);
    }

    public static function checkIfUserExists($email)
    {
        $count = self::getCount(['email' => $email]);
        if ($count > 0) {
            throw new \LogicException('Customer with email: '.$email.' already exists');
        }
    }

    public function createUserId()
    {
        return $this->userId =  uniqid(strtolower($this->fname));
    }

    public static function configure($object, $props)
    {
        foreach ($props as $name => $value) {

            if ($name === 'password') {
                $arr = self::hash($value);
                $object->pass_hash = $arr['hash'];
                $object->salt = $arr['salt'];
            }

            $object->$name = $value;
            //self::setProps($name, $value);
        }

        return $object;
    }

    public static function hash($subject){
        $random = openssl_random_pseudo_bytes(18);
        $salt = sprintf('$2y$%02d$%s', 13,  substr(strtr(base64_encode($random),'+','.'), 0,22));
        $hash = crypt($subject, $salt);

        return array('hash' => $hash, 'salt' => $salt);
    }

    public static function check_hash($givenHash, $dbHash){

        $givenHash = crypt($givenHash, $dbHash);
        $n1 = strlen($givenHash);

        if(strlen($dbHash) != $n1){
            return false;
        }
        for($i = 0, $diff = 0;$i != $n1; ++$i){
            $diff |= ord($givenHash[$i]) ^ ord($dbHash[$i]);
        }
        return !$diff;
    }


    /**
     * @return Database
     */
    public static function getDb()
    {
        return self::$db;
    }

    /**
     * @param Database $db
     */
    public static function setDb($db)
    {
        self::$db = $db;
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
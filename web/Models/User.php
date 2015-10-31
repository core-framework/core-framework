<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 18/02/15
 * Time: 8:47 PM
 */

namespace web\Models;

use Core\Database\Connection;
use Core\Models\Model;

class User extends Model {

    protected static $tableName = 'user';
    protected static $primaryKey = 'userId';
    protected static $dbName = 'test';

    public static $columnSaveBlacklist = ['csrf', 'id', 'password', 'password_confirm', 'register_date', 'submitted_date', 'modified_date'];

    public $fname;
    public $lname;
    public $name;
    public $userId;
    public $email;
    public $email_hash;
    public $pass_hash;
    public $salt;


    public function __construct(array $userData = [], Connection $connection = null)
    {
        if (!empty($userData)) {
            self::configure($this, $userData);
            $this->createUserId();
            $this->createPassHash();
        }

        parent::__construct($connection);
    }

    public function save()
    {
        self::checkIfUserExists($this->email);
        return parent::save();
    }

    public function update()
    {
        return parent::update();
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
        }

        return $object;
    }

    public function createPassHash()
    {
        $hashArr = self::hash($this->password);
        $this->pass_hash = $hashArr['hash'];
        $this->salt = $hashArr['salt'];
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
}
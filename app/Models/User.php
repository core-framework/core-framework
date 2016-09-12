<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 18/02/15
 * Time: 8:47 PM
 */

namespace app\Models;

use Core\Model\Model;
use Core\Facades\Password;

class User extends Model {

    protected static $tableName = 'user';

    protected static $primaryKey = 'userId';

    protected static $dbName = '';

    protected static $saveable = ['fname', 'lname', 'name', 'userId', 'email', 'email_hash', 'pass_hash'];

    protected static $fillable = ['fname', 'lname', 'name', 'userId', 'email', 'email_hash', 'pass_hash', 'password'];

    public $fname;
    public $lname;
    public $name;
    public $userId;
    public $email;
    public $email_hash;
    public $pass_hash;
    public $salt;

    protected function beforeSave()
    {
        $this->checkIfUserExists($this->email);
        $this->createUserId();
        $this->createPassHash();
        parent::beforeSave();
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

    public function createPassHash()
    {
        $this->pass_hash = Password::hash($this->password);
    }

    public static function authenticate(User $user, $password)
    {
        return Password::verify($password, $user->pass_hash);
    }
}
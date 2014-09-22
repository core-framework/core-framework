<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 15/09/14
 * Time: 9:54 AM
 */

namespace Core\Databases;
use PDO;

class database extends PDO {
    private $dsn;
    private $u;
    private $p;
    protected static $instance;
    protected $cache = [];



    public function __construct($db = null){

        global $_CONFIG;

        if($db == "ADD_NEW" || $db == ""){
            $rdb = "";
        }elseif($db != null && $db != "ADD_NEW"){
            $rdb = "dbname=".$db;
        }else{
            $rdb = "dbname=".$_CONFIG['db'];
        }
        $dsn = 'mysql:host='.$_CONFIG['host'].';'.$rdb;

        $u = $_CONFIG['user'];
        $p = $_CONFIG['pass'];

        $this->u = $u;
        $this->dsn = $dsn;
        $this->p = $p;
        //$this->dbh = new \PDO($dsn, $u, $p);
        parent::__construct($dsn, $u, $p);
        $this->cache = [];
    }

    public static function getInstance($db = null){
        if(!self::$instance){
            self::$instance = new database($db);
        }
        return self::$instance;
    }

    public function getPrepared($query){
        $hash = md5($query);
        if(!isset($this->cache[$hash])){
            $this->cache[$hash] = $this->prepare($query);
        }
        return $this->cache[$hash];
    }

    public function __destruct(){
        $this->cache = null;
    }


} 
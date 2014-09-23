<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Databases;
use PDO;

/**
 * @author Shalom Sam <shalom.s@coreframework.in>
 * Class database
 * @package Core\Databases
 */
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
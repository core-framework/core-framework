<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Database;
use Core\Config\config;
use PDO;

/**
 * This class is the base database class which is an extension of PDO
 *
 * @package Core\Database
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class database extends PDO {
    /**
     * @var string Database connections sting
     */
    private $dsn;
    /**
     * @var mixed Database user
     */
    private $u;
    /**
     * @var mixed Database password
     */
    private $p;
    /**
     * @var object Database instance
     */
    protected static $instance;
    /**
     * @var array Database cache reference
     */
    protected $cache = [];


    /**
     * Creates an instance of the pdo class
     *
     * @param null $db
     */
    public function __construct($db = null){

        $configObj = new config();


        if($db == "ADD_NEW" || $db == ""){
            $rdb = "";
        }elseif($db != null && $db != "ADD_NEW"){
            $rdb = "dbname=".$db;
        }else{
            $rdb = "dbname=".$configObj->db;
        }
        $dsn = $configObj->pdoDriver.':host='.$configObj->host.';'.$rdb;

        $u = $configObj->user;
        $p = $configObj->pass;

        $this->u = $u;
        $this->dsn = $dsn;
        $this->p = $p;
        parent::__construct($dsn, $u, $p);
        $this->cache = [];
    }

    /**
     * Returns the object reference or the instance of the class
     *
     * @param null $db
     * @return database
     */
    public static function getInstance($db = null){
        if(!self::$instance){
            self::$instance = new database($db);
        }
        return self::$instance;
    }

    /**
     * Gets the prepared statement
     *
     * @param $query
     * @return mixed
     */
    public function getPrepared($query){
        $hash = md5($query);
        if(!isset($this->cache[$hash])){
            $this->cache[$hash] = $this->prepare($query);
        }
        return $this->cache[$hash];
    }

    /**
     * Reset database cache
     *
     */
    public function __destruct(){
        $this->cache = null;
    }


} 
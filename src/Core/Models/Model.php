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

namespace Core\Models;

use Core\Database\Database;

/**
 * This is the base model class for Core Framework
 *
 * @package Core\Models
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class Model
{
    /**
     * @var string Database table name
     */
    protected static $tableName = '';
    /**
     * @var string Table primary key
     */
    protected static $primaryKey = '';
    /**
     * @var database database object instance
     */
    protected $db;
    /**
     * @var array Model properties array
     */
    protected $props = [];

    /**
     *  Model constructor
     */
    public function __construct()
    {

    }

    /**
     * Executes a simple 'SELECT * (all columns)' statement with parameters provided
     *
     * @param array $conditions
     * @param null $orderBy
     * @param null $startIndex
     * @param null $count
     * @return array
     */
    static function getAllRows(array $conditions, $orderBy = null, $startIndex = null, $count = null)
    {
        $query = "SELECT * FROM " . static::$tableName;
        $params = [];
        if (!empty($conditions)) {
            $query .= " WHERE ";
            foreach ($conditions as $key => $val) {
                $query .= $conditions[':' . $key] = $key . " AND ";
                $params[':' . $key] = $val;
            }
        }
        $query = rtrim($query, ' AND ');
        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $orderBy;
        }
        if (!empty($orderBy)) {
            $query .= " LIMIT " . $startIndex;
            if (!empty($query)) {
                $query .= "," . $count;
            }
        }
        return self::get($query, $params);

    }

    /**
     * Returns a collection of rows for the given query
     *
     * @param $query
     * @param array $params
     * @return array
     */
    public static function get($query, array $params)
    {
        $db = database::getInstance();
        $prep = $db->getPrepared($query);
        $prep->execute($params);
        $result = $prep->fetchAll(\PDO::FETCH_ASSOC);
        $collection = [];
        $className = get_called_class();
        foreach ($result as $row) {
            $item = new $className();
            $item->getPropFromDb($row);
            array_push($collection, $item);
        }
        return $collection;
    }

    /**
     * Outputs one row based on the primary key provided
     *
     * @param $value
     * @return mixed
     */
    public static function getByPrimaryKey($value)
    {
        $prop = [];
        $prop[static::$primaryKey] = $value;
        return self::getOneRow($prop);
    }

    /**
     * Returns one row based on the provided condition
     *
     * @param array $conditions
     * @return mixed
     */
    public static function getOneRow(array $conditions)
    {
        $query = "SELECT * FROM " . static::$tableName;
        $params = [];
        if (!empty($conditions)) {
            $query .= " WHERE ";
            foreach ($conditions as $key => $val) {
                $query .= $key . "=:" . $key . " AND ";
                $condition[":" . $key] = $val;
            }
        }
        $query = rtrim($query, ' AND ');
        return self::getFromDbandBuildObj($query, $params);
    }

    /**
     * Returns an object of the class that calls this function, filled with values from the database, based on the query provided
     *
     * @param $query
     * @param array $params
     * @return mixed
     */
    private function getFromDbandBuildObj($query, array $params)
    {
        $db = database::getInstance();
        $prep = $db->getPrepared($query);
        $prep->execute($params);
        $row = $prep->fetch(\PDO::FETCH_ASSOC);
        $className = get_called_class();
        $obj = new $className();
        $obj->getPropFromDb($row);
        return $obj;
    }

    /**
     * Returns count of rows according to the parameters provided
     *
     * @param array $conditions
     * @return mixed
     */
    public static function getCount(array $conditions)
    {
        $query = "SELECT COUNT(*) FROM " . static::$tableName;
        $params = [];
        if (!empty($conditions)) {
            $query .= " WHERE ";
            foreach ($conditions as $key => $val) {
                $query .= $key . ":=" . $key . " AND ";
                $params[":" . $key] = $val;
            }
        }
        $query = rtrim($query, ' AND ');
        return self::getFromDb($query, $conditions);
    }

    /**
     * Gets the query result from Database
     *
     * @param $query
     * @param array $params
     * @return mixed
     */
    private function getFromDb($query, array $params)
    {
        $db = database::getInstance();
        $prep = $db->getPrepared($query);
        $prep->execute($params);
        $arr = $prep->fetch();
        return $arr[0];
    }

    /**
     * Returns the array of properties set to be saved/updated
     *
     * @param $param
     * @return mixed
     */
    public function getProps($param)
    {
        return $this->props[$param];
    }

    /**
     * Sets the properties to be saved/updated on database into an array
     *
     * @param $param
     * @param $val
     */
    public function setProps($param, $val)
    {
        $this->props[$param] = $val;
    }

    /**
     * Updates the database with the properties set
     */
    public function save()
    {
        $query = "REPLACE INTO " . static::$tableName . " (" . implode(",", array_keys($this->props)) . ") VALUES(";
        $keys = [];
        foreach ($this->props as $key => $value) {
            $keys[":" . $key] = $value;
        }
        $query .= implode(",", array_keys($keys)) . ")";
        $db = database::getInstance();
        $prep = $db->getPrepared($query);
        $prep->execute($keys);
    }

    /**
     * Deletes row from the database table
     */
    public function delete()
    {
        $query = "DELETE FROM " . static::$tableName . " WHERE " . static::$primaryKey . "=:id LIMIT 1";
        $db = database::getInstance();
        $prep = $db->getPrepared($query);
        $prep->execute(array(':id' => $this->props[static::$primaryKey]));
    }

    /**
     * Simply fills the $prop array with properties from a given array
     *
     * @param array $prop
     */
    public function getPropFromDb(array $prop)
    {
        foreach ($prop as $key => $val) {
            $this->props[$key] = $val;
        }
    }
}
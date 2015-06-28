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

use Core\Databases\Database;

/**
 * This is the base model class for Core Framework
 *
 * @package Core\Models
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class Model extends BaseModel
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
     * @var string Database name
     */
    protected static $dbName = '';
    /**
     * @var database database object instance
     */
    protected static $db;

    /**
     * Model Constructor
     *
     * @param Database $db
     */
    public function __construct($db = null)
    {
        if (is_null($db)) {
            self::$db = $this->getConnection();
        }
        elseif ($db instanceof Database) {
            self::$db = $db;
        }
        else {
            throw new \LogicException("Database object missing");
        }
    }

    /**
     * Executes a simple 'SELECT * (all columns)' statement with parameters provided
     *
     * @param array $conditions
     * @param null $orderBy
     * @param null $order
     * @param null $startIndex
     * @param null $count
     * @param $asArray
     *
     * @return array
     */
    static function getAllRows(
        $conditions = [],
        $orderBy = null,
        $order = null,
        $startIndex = null,
        $count = null,
        $asArray = false
    ) {
        $query = "SELECT * FROM " . static::$tableName;
        $params = [];
        if (!empty($conditions)) {
            $query .= " WHERE ";
            foreach ($conditions as $key => $val) {
                $query .= $key . "=:" . $key . " AND ";
                $params[':' . $key] = $val;
            }
        }
        $query = rtrim($query, ' AND ');
        if (!empty($orderBy)) {
            $query .= " ORDER BY " . $orderBy;
            $query .= " " . $order;
        }
        if (!is_null($startIndex) && !is_null($count)) {
            $query .= " LIMIT " . $startIndex;
            if (!empty($query)) {
                $query .= "," . $count;
            }
        }
        if ($asArray === false) {
            return self::get($query, $params);
        } else {
            return self::getAsArray($query, $params);
        }


    }

    /**
     * Returns a collection of rows for the given query
     *
     * @param $query
     * @param array $params
     * @return array
     */
    public static function get($query, $params = [])
    {
        //$db = database::getInstance();
        $prep = self::$db->getPrepared($query);
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

    public static function getAsArray($query, $params = [])
    {
        $prep = self::$db->getPrepared($query);
        $prep->execute($params);
        $result = $prep->fetchAll(\PDO::FETCH_ASSOC);
        $collection = [];
        foreach ($result as $row) {
            array_push($collection, $row);
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
                $params[":" . $key] = $val;
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
    private static function getFromDbandBuildObj($query, $params = [])
    {
        $prep = self::$db->getPrepared($query);
        $prep->execute($params);
        $row = $prep->fetch(\PDO::FETCH_ASSOC);
        $className = get_called_class();
        $obj = new $className();
        if ($row !== false) {
            $obj->getPropFromDb($row);
            return $obj;
        } else {
            return false;
        }


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
                $query .= $key . "=:" . $key . " AND ";
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
    public static function getFromDb($query, array $params)
    {
        $db = self::$db;
        $prep = $db->getPrepared($query);
        $prep->execute($params);
        $arr = $prep->fetch();
        return $arr[0];
    }

    /**
     * Unset un-used parameters before storing in Database
     */
    public function unsetBeforeSave()
    {

    }

    /**
     * Updates the database with the properties set
     */
    public function save()
    {
        $query = "REPLACE INTO " . static::$tableName . " (" . implode(
                ",",
                array_filter(array_keys((array)$this))
            ) . ") VALUES(";
        $keys = [];
        //foreach ($this->props as $key => $value) {
        foreach ($this as $key => $value) {
            $keys[":" . $key] = $value;
        }
        $query .= implode(",", array_keys($keys)) . ")";
        $db = self::$db;
        $prep = $db->getPrepared($query);
        $r = $prep->execute($keys);

        return $r;
    }

    public function update()
    {
        $query = "UPDATE " . static::$tableName . " SET ";
        $keys = [];
        foreach ($this as $key => $val) {
            $keys[":" . $key] = $val;
            $query .= "$key=:$key,";
        }
        $query = rtrim($query, ',');
        $query .= " WHERE ";
        $query .= static::$primaryKey . "=:" . static::$primaryKey;
        $primaryKey = static::$primaryKey;
        $keys[static::$primaryKey] = $this->$primaryKey;
        $query = rtrim($query, ' AND ');

        $db = self::$db;
        $prep = $db->getPrepared($query);
        $r = $prep->execute($keys);

        return $r;
    }

    /**
     * Deletes row from the database table
     */
    public function delete()
    {
        $query = "DELETE FROM " . static::$tableName . " WHERE " . static::$primaryKey . "=:id LIMIT 1";
        $db = self::$db;
        $prep = $db->getPrepared($query);
        $primaryKey = static::$primaryKey;
        $r = $prep->execute(array(':id' => $this->$primaryKey));

        return $r;
    }

    /**
     * Simply fills the $prop array with properties from a given array
     *
     * @param array $prop
     */
    public function getPropFromDb(array $prop)
    {
        foreach ($prop as $key => $val) {
            $this->$key = $val;
        }
    }
}
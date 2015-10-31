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

use Core\Database\Connection;

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
     * @param array $columns
     * @param Connection|null $connection
     */
    public function __construct(array $columns = null, Connection $connection = null)
    {
        if (is_null($connection)) {
            static::$connection = $this->getConnection();
        }
        elseif ($connection instanceof Connection) {
            static::$connection = $connection;
        }
        else {
            throw new \LogicException("Database object missing");
        }

        if (!empty($columns)) {
            static::configure($this, $columns);
        }
    }


    /**
     * Unset un-used parameters before storing in Database
     *
     * @param bool|true $unsetDates
     */
    public function beforeSave($unsetDates = true)
    {
        foreach(static::$columnSaveBlacklist as $column) {
            unset($this->$column);
        }

        if ($unsetDates === true) {
            unset($this->created_at);
            unset($this->modified_at);
        }
    }

    /**
     * Updates the database with the properties set
     */
    public function save()
    {
        $this->beforeSave();
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
        $db = self::$connection;
        $prep = $db->getPrepared($query);
        $r = $prep->execute($keys);

        return $r;
    }

    public function update()
    {
        $this->beforeSave();
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

        $db = self::$connection;
        $prep = $db->getPrepared($query);
        $r = $prep->execute($keys);

        return $r;
    }

    /**
     * Deletes row from the database table
     */
    public function delete()
    {
        $this->beforeSave();
        $query = "DELETE FROM " . static::$tableName . " WHERE " . static::$primaryKey . "=:id LIMIT 1";
        $db = self::$connection;
        $prep = $db->getPrepared($query);
        $primaryKey = static::$primaryKey;
        $r = $prep->execute(array(':id' => $this->$primaryKey));

        return $r;
    }


}
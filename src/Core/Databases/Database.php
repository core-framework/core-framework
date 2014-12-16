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
class Database extends PDO
{
    /**
     * @var array Internal Caching
     */
    private $cache = [];

    /**
     * Creates an instance of the pdo class
     *
     * @param array $array
     * @throws \ErrorException
     * @throws \Exception
     */
    public function __construct(array $array = [])
    {

        if(empty($array)) {
            throw new \ErrorException("Connection parameters cannot be empty.");
        }

        if ($array['db'] == "") {
            $db = "";
        } elseif ($array['db'] != null) {
            $db = "dbname=" . $array['db'];
        }

        if (!empty($array['type'])) {
            $type = $array['type'];
        } else {
            $type = "mysql";
        }

        if (!empty($array['host'])) {
            $host = $array['host'];
        } else {
            throw new \Exception("Database Host not provided.");
        }

        if (!empty($array['username'])) {
            $user = $array['username'];
        } else {
            $user = null;
        }

        if (!empty($array['password'])) {
            $pass = $array['password'];
        } else {
            $pass = null;
        }

        if (!empty($array['port'])) {
            $port = "port=" . $array['port'];
        } else {
            $port = "";
        }

        $dsn = $type . ':' . $db . ';' . 'host=' . $host . ';' . $port;

        $dsnString = $dsn;

        if (isset($array['dsn'])) {
            $dsn = $array['type'] . ":";
            $dsnAttrArr = [];
            foreach($array['dsn'] as $key => $val) {
                $dsnAttrArr[] = $key . "=" . $val;
            }

            $dsnAttr = implode(";", $dsnAttrArr);

            $dsnString = $dsn . $dsnAttr;
        }

        return parent::__construct($dsnString, $user, $pass);
    }

    /**
     * Gets the prepared statement
     *
     * @param $query
     * @return mixed
     */
    public function getPrepared($query)
    {
        $hash = md5($query);
        if (!isset($this->cache[$hash])) {
            $this->cache[$hash] = $this->prepare($query);
        }
        return $this->cache[$hash];
    }

    /**
     * Reset database cache
     */
    public function __destruct()
    {
        $this->cache = null;
    }

}
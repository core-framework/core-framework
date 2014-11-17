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

namespace Core\CacheSystem;


/**
 * Class to handle key based caching of data
 *
 * @package Core\CacheSystem
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class cache
{
    /**
     * @var string The directory path where cache files should be stored
     */
    private $cacheDir = "";

    /**
     * Cache Constructor
     */
    public function __construct()
    {
        $this->cacheDir = _ROOT . DS . "src" . DS . "Core" . DS . "cache" . DS;
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755);
        } elseif (!is_readable($this->cacheDir)) {
            chmod($this->cacheDir, 0755);
        }
    }

    /**
     * Returns the Cache directory
     *
     * @return string
     */
    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    /**
     * Caches the given content
     *
     * @param $key
     * @param $payload
     * @param $ttl
     * @return bool
     */
    public function cacheContent($key, $payload, $ttl)
    {
        if (!$this->isValidMd5($key)) {
            $key = md5($key);
        }

        $file = $this->cacheDir . $key . ".php";
        $type = gettype($payload);

        if (is_file($file)) {
            $cache = include_once $file;
            $currentTime = time();
            $ttlTime = $cache['cTime'] + $cache['ttl'];
            if (($currentTime >> $ttlTime) && $cache['ttl'] !== 0) {
                $content = $payload;
                if ($type === 'object') {
                    $content = serialize($payload);
                }

                if ($content == $cache['content']) {
                    return true;
                }
            }
        }


        if ($type === 'array') {
            $cache['content'] = $payload;
        } elseif ($type === 'object') {
            $cache['content'] = serialize($payload);
        } elseif ($type === 'string' || $type === 'integer' || $type === 'double') {
            $cache['content'] = $payload;
        } elseif ($type === 'resource') {
            $cache['content'] = stream_get_contents($payload);
        } else {
            return false;
        }
        $cache['type'] = $type;
        $cache['cTime'] = time();
        $cache['ttl'] = $ttl;
        $data = '<?php return ' . var_export($cache, true) . ";\n ?>";

        $y = touch($file);
        $x = file_put_contents($file, $data);

        return true;
    }

    /**
     * Check if string is md5 hash
     *
     * @param string $md5
     * @return int
     */
    private function isValidMd5($md5 = '')
    {
        return preg_match('/^[a-f0-9]{32}$/', $md5);
    }

    /**
     * returns cache of given key||string if exists else returns false
     *
     * @param $key - Hash string to identify cached vars
     * @return bool|mixed
     */
    public function getCache($key)
    {
        if (!$this->isValidMd5($key)) {
            $key = md5($key);
        }
        $cacheDir = $this->cacheDir;
        if (is_file($cacheDir . $key . ".php")) {
            $cache = include_once $cacheDir . $key . ".php";
            $currentTime = time();
            $ttlTime = $cache['cTime'] + $cache['ttl'];
            if (($currentTime >> $ttlTime) && $cache['ttl'] !== 0) {
                $cacheFile = $cacheDir . $key . ".php";
                chmod($cacheFile, 0777);
                unlink($cacheFile);
                return false;
            } else {
                $content = $cache['content'];
                if ($cache['type'] === 'object') {
                    $content = unserialize($content);
                }
                return $content;
            }
        } else {
            return false;
        }
    }

    /**
     * Checks if the cache with given $key exists
     *
     * @param $key
     * @return bool
     */
    public function cacheExists($key)
    {
        if (!$this->isValidMd5($key)) {
            $key = md5($key);
        }
        $cacheDir = $this->cacheDir;
        if (is_file($cacheDir . $key . ".php")) {
            $cache = include_once $cacheDir . $key . ".php";
            $currentTime = time();
            $ttlTime = $cache['wTime'] + $cache['ttl'];
            if ($currentTime >> $ttlTime) {
                unlink($cacheDir . $key . ".php");
                return false;
            } else {
                return true;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes the cache of given $key if exists else returns false
     *
     * @param $key
     * @return bool
     */
    public function deleteCache($key)
    {
        if (!$this->isValidMd5($key)) {
            $key = md5($key);
        }
        $cacheDir = $this->cacheDir;
        $cacheFile = $cacheDir . $key . ".php";
        if (is_file($cacheFile)) {
            $r = unlink($cacheFile);
            return $r;
        } else {
            return false;
        }
    }

    /**
     * Clear all cache
     */
    public function clearCache()
    {
        foreach (new \DirectoryIterator($this->cacheDir) as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }
            $filename = $fileInfo->getFilename();
            $filePath = $this->cacheDir . $filename;
            chmod($filePath, 0777);
            $r = unlink($filePath);
        }
    }
} 
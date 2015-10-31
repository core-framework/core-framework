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


use Core\CacheSystem\AppCache;
use Core\CacheSystem\Cache;

if ( ! function_exists('core_serialize') ) {

    /**
     * Method to serialize array (comma separated values as single string)
     *
     * @param array $arr
     * @param string $delimiter
     * @return string
     */
    function core_serialize(array $arr, $delimiter = ", ")
    {
        $serialized = "";
        if (!key($arr)) {
            foreach ($arr as $item) {
                $serialized .= $item . $delimiter;
            }
            $serialized = rtrim($serialized, $delimiter);
            return $serialized;
        } elseif (sizeof(key($arr)) > 0) {
            foreach ($arr as $key => $val) {
                $serialized .= $val . ", ";
            }
            $serialized = rtrim($serialized, $delimiter);
            return $serialized;
        }
    }
}



if (! function_exists('core_unserialize')) {

    /**
     * @param $serialized
     * @param string $delimiter
     * @return array
     */
    function core_unserialize($serialized, $delimiter = ", ")
    {
        return explode($delimiter, $serialized);
    }
}

if (! function_exists('copyr')) {

    /**
     * Method to copy files and directories recursively
     *
     * @param $source
     * @param $dest
     * @param bool $override
     * @throws \Exception
     */
    function copyr($source, $dest, $override = false)
    {
        $dir = opendir($source);
        if (!is_dir($dest)) {
            mkdir($dest);
        } else {
            chmod($dest, 0755);
        }
        if (is_resource($dir)) {
            while (false !== ($file = readdir($dir))) {
                if (($file != '.') && ($file != '..')) {
                    if (is_dir($source . DS . $file)) {
                        copyr($source . DS . $file, $dest . DS . $file);
                    } elseif (is_readable($dest . DS . $file) && $override === true) {
                        copy($source . DS . $file, $dest . DS . $file);
                    } elseif (!is_readable($dest . DS . $file)) {
                        copy($source . DS . $file, $dest . DS . $file);
                    }
                }
            }
        } else {
            throw new \Exception("readdir() expects parameter 1 to be resource", 10);
        }
        closedir($dir);
    }
}


if (! function_exists('chmodDirFiles') ) {

    /**
     * Method to change the permission for files recursively
     *
     * @param $dir
     * @param null $mod
     * @param bool $recursive
     */
    function chmodDirFiles($dir, $mod = null, $recursive = true)
    {
        chmod($dir, 0755);
        if ($recursive && $objs = glob($dir . DS . "*")) {
            foreach ($objs as $file) {
                if (is_dir($file)) {
                    chmodDirFiles($file, $mod, $recursive);
                } else {
                    change_perms($file, $mod);
                }
            }
        }
    }
}


if (! function_exists('change_perms')) {

    /**
     * Method to change the permission of a single file
     *
     * @param $obj
     * @param null $mod
     */
    function change_perms($obj, $mod = null)
    {
        chmod($obj, empty($mod) ? 0755 : $mod);
    }
}


if (! function_exists('searchArrayByKey')) {

    /**
     * Searches given array for given key and return the value of that key. Returns false if nothing was found
     *
     * @param array $array
     * @param $search
     * @return bool|mixed
     */
    function searchArrayByKey(array $array, $search) {
        foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($array)) as $key => $value) {
            if ($search === $key)
            return $value;
        }
        return false;
    }
}


if (! function_exists('requireCached') ) {

    /**
     * Requires cached version of file if exists else caches the given file and requires the given file
     *
     * @param $filePath
     * @return bool|mixed
     * @throws ErrorException
     */
    function requireCached($filePath) {
        new AppCache();

        if (AppCache::cacheExists($filePath)) {
            $cache = AppCache::getCache($filePath);
            if (is_bool($cache)) {
                AppCache::cacheContent($filePath, require($filePath), 10000);
                return require($filePath);
            } else {
                return $cache;
            }
        } else {
            AppCache::cacheContent($filePath, require($filePath), 10000);
            return require($filePath);
        }
    }
}
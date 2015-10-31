<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 24/10/15
 * Time: 11:05 AM
 */

namespace Core\CacheSystem;


class AppCache implements CacheInterface
{
    /**
     * @var bool $dirIsGiven
     */
    public static $dirIsGiven = false;
    private static $dirRequiresPermissions = false;

    /**
     * @var string The directory path where cache files should be stored
     */
    private static $cacheDir = "";

    /**
     * Cache Constructor
     */
    public function __construct()
    {
        //defined('DS') or define('DS', DIRECTORY_SEPARATOR);
        defined('_ROOT') or define('_ROOT', realpath(__DIR__ . "/../../.."));
        static::setCacheDir(_ROOT . "/storage/framework/cache/");
    }

    public static function setCacheDir($dir)
    {
        self::$dirIsGiven = true;
        self::$cacheDir = $dir;
        if (!is_dir(self::$cacheDir)) {
            mkdir(self::$cacheDir, 0777);
        } elseif (!is_readable(self::$cacheDir)) {
            chmod(self::$cacheDir, 0755);
        }

        $perms = substr(decoct(fileperms(static::$cacheDir)),2);

        if (decoct($perms) !== 0777) {
            self::$dirRequiresPermissions = true;
        }
    }

    /**
     * Returns the Cache directory
     *
     * @return string
     */
    public function getCacheDir()
    {
        return self::$cacheDir;
    }

    /**
     * Caches the given content
     *
     * @param $key string
     * @param $payload mixed
     * @param $ttl int
     * @return bool
     * @throws \ErrorException
     */
    public static function cacheContent($key, $payload, $ttl)
    {
        if (!self::$dirIsGiven) {
            throw new \ErrorException("Cache Directory not defined!");
        }

        $cache = [];
        if (!static::isValidMd5($key)) {
            $key = md5($key);
        }

        $file = self::$cacheDir . $key . ".php";
        $type = gettype($payload);

        if (is_file($file)) {
            $cache = include_once $file;
            $currentTime = time();
            $ttlTime = $cache['cTime'] + $cache['ttl'];
            if (($currentTime >> $ttlTime) && $cache['ttl'] !== 0) {
                $content = $payload;
                if ($type === 'object' && $payload instanceof Cacheable) {
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
            if ($payload instanceof Cacheable) {
                $cache['content'] = serialize($payload);
            } else {
                throw new \InvalidArgumentException("Object must implement Cacheable interface");
            }
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

        if (touch($file) === false) {
            throw new \ErrorException("Unable to create cache file.");
        }
        if (file_put_contents($file, $data) === false) {
            throw new \ErrorException("Unable to write to file.");
        }

        return true;
    }

    /**
     * returns cache of given key||string if exists else returns false
     *
     * @param $key - Hash string to identify cached vars
     * @return bool|mixed
     * @throws \ErrorException
     */
    public static function getCache($key)
    {
        if (!self::$dirIsGiven) {
            throw new \ErrorException("Cache Directory not defined!");
        }
        if (!static::isValidMd5($key)) {
            $key = md5($key);
        }
        $cacheDir = self::$cacheDir;
        if (is_file($cacheDir . $key . ".php")) {
            $cache = include $cacheDir . $key . ".php";
            $currentTime = time();
            $ttlTime = $cache['cTime'] + $cache['ttl'];
            if (($currentTime > $ttlTime) && $cache['ttl'] !== 0) {
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
     * @throws \ErrorException
     */
    public static function cacheExists($key)
    {
        if (!self::$dirIsGiven) {
            throw new \ErrorException("Cache Directory not defined!");
        }
        if (!static::isValidMd5($key)) {
            $key = md5($key);
        }
        $cacheDir = self::$cacheDir;
        if (is_file($cacheDir . $key . ".php")) {
            $cache = include_once $cacheDir . $key . ".php";
            $currentTime = time();
            $ttlTime = $cache['cTime'] + $cache['ttl'] + 100;
            if ($currentTime >> $ttlTime) {
                unlink($cacheDir . $key . ".php");
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Deletes the cache of given $key if exists else returns false
     *
     * @param $key
     * @return bool
     * @throws \ErrorException
     */
    public static function deleteCache($key)
    {
        if (!self::$dirIsGiven) {
            throw new \ErrorException("Cache Directory not defined!");
        }
        if (!static::isValidMd5($key)) {
            $key = md5($key);
        }
        $cacheDir = self::$cacheDir;
        $cacheFile = $cacheDir . $key . ".php";
        if (is_file($cacheFile)) {
            $r = unlink($cacheFile);
            return $r;
        } else {
            return false;
        }
    }

    /**
     * Clears all cache (deletes all cache file in the Cache Dir)
     *
     * @throws \ErrorException
     * @throws \Exception
     */
    public static function clearCache()
    {
        if (!self::$dirIsGiven) {
            throw new \ErrorException("Cache Directory not defined!");
        }
        foreach (new \DirectoryIterator(self::$cacheDir) as $fileInfo) {
            if ($fileInfo->isDot()) {
                continue;
            }
            $filename = $fileInfo->getFilename();
            $ext = $fileInfo->getExtension();
            $filePath = self::$cacheDir . $filename;
            @chmod($filePath, 0777);

            if ($ext !== 'php') {
                continue;
            }

            if (unlink($filePath) === false) {
                throw new \Exception("Unable to clear Cache.");
            }
        }
    }

    /**
     * Check if string is $key hash
     *
     * @param string $key
     * @return int
     */
    public static function isValidMd5($key = '')
    {
        return preg_match('/^[a-f0-9_]{32}$/', $key);
    }
}
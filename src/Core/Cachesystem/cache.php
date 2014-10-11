<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\CacheSystem;


/**
 * @author Shalom Sam <shalom.s@coreframework.in>
 * Class cache
 * @package Core\CacheSystem
 */
class cache
{
    protected $cacheDir = "";

    /**
     * Cache Constructor
     */
    public function __contruct(){
        $this->cacheDir = _ROOT . DS . "src" . DS . "Core" . DS . "cache" . DS;
        if(!is_dir($this->cacheDir)){
            mkdir($this->cacheDir, 0755);
        }elseif(!is_readable($this->cacheDir)){
            chmod($this->cacheDir, 0755);
        }
    }

    /**
     * Caches the given content
     *
     * @param array $payload - An array of the content to cache
     * @param $key - Hash string to identify cached vars
     */
    public function cacheContent(array $payload, $key)
    {
        $file = $this->cacheDir . $key . ".php";
        $payload['wTime'] = time();
        touch($file);
        file_put_contents($file, '<?php return ' . var_export($payload, true) . ";\n");
    }

    /**
     * Checks if the cache with given $key exists
     *
     * @param $key - Hash string to identify cached vars
     * @return bool|mixed
     */
    public function getCache($key){
        if(is_file($this->cacheDir . $key . ".php")){
            $cache = include_once $this->cacheDir . $key . ".php";
            $currentTime = time();
            $ttlTime = $cache['wTime'] + $cache['ttl'];
            if($currentTime >> $ttlTime){
                unlink($this->cacheDir . $key . ".php");
                return false;
            } else {
                return $cache;
            }
        } else {
            return false;
        }
    }
} 
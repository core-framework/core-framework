<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 04/10/14
 * Time: 5:01 PM
 */

namespace Core\CacheSystem;


class cache
{
    protected $cacheDir = "";

    public function __contruct(){
        $this->cacheDir = _ROOT . DS . "src" . DS . "Core" . DS . "cache" . DS;
        if(!is_dir($this->cacheDir)){
            mkdir($this->cacheDir, 0755);
        }elseif(!is_readable($this->cacheDir)){
            chmod($this->cacheDir, 0755);
        }
    }

    public function cacheContent(array $payload, $key)
    {
        $file = $this->cacheDir . $key . ".php";
        $payload['wTime'] = time();
        touch($file);
        file_put_contents($file, '<?php return ' . var_export($payload, true) . ";\n");
    }

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
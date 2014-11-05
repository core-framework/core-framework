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
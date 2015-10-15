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

namespace Core\Config;

/**
 * Class to load Core Framework configurations
 *
 * <code>
 *  $config = new Config();
 *  //set config params
 *  $config->someProp = 'someValue';
 *  //get set config params or params defined in config.php
 *  $someProp = $config->someProp
 *
 *  //store config data to file
 *  $config->store('someKey', 'someValue');
 * </code>
 *
 * @package Core\Config
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class Config
{
    public static $global = [];
    public $allConfPath;
    private $allConfig = [];
    /**
     * @var array Global configurations path
     */
    public $globalPath;
    /**
     * @var array Global configurations
     */
    private $globalConfig = [];
    /**
     * @var array Routes configurations Path
     */
    public $routesConfPath;
    /**
     * @var array Routes Configurations
     */
    private $routesConfig = [];
    /**
     * @var array DB configurations
     */
    private $dbConfig = [];
    /**
     * @var string Cli config path
     */
    public $cliConfPath;
    /**
     * @var array|mixed Cli script configurations
     */
    private $cliConf = [];

    /**
     * Constructor to load configurations
     */
    public function __construct()
    {
        if(!defined('_APPDIR')) {
            define('_APPDIR', _ROOT . "/web");
        }

        $this->allConfPath = $allConfPath = _APPDIR . "/config/all.conf.php";
        $this->globalConfPath = _APPDIR . "/config/global.conf.php";
        $this->cliConfPath = $cliConfPath = _ROOT . "/src/Core/Scripts/cli.conf.php";

        //allConf
        if(is_readable($allConfPath)) {
            $this->allConfig = include $allConfPath;
            static::$global = $this->allConf;

            $this->globalConfig = isset ($this->allConfig['$global']) ? $this->allConfig['$global'] : [];
            $this->routesConfig = isset ($this->allConfig['$routes']) ? $this->allConfig['$routes'] : [];
            $this->dbConfig = isset ($this->allConfig['$db']) ? $this->allConfig['$db'] : [];

            if (!is_array($this->allConf)) {
                $this->allConf = [];
            }
        } else {
            trigger_error("Config files missing!");
        }

        //CliConf
        if(is_readable($cliConfPath)) {
            $this->cliConf = include $cliConfPath;
            if (!is_array($this->cliConf)) {
                $this->cliConf = [];
            }
        } else {
            touch($cliConfPath, 0755);
        }

    }

    public function reloadConfig()
    {
        if(is_readable($this->allConfPath)) {
            $this->allConf = include $this->allConfPath;
            $this->globalConfig = isset ($this->allConfig['$global']) ? $this->allConfig['$global'] : [];
            $this->routesConfig = isset ($this->allConfig['$routes']) ? $this->allConfig['$routes'] : [];
            $this->dbConfig = isset ($this->allConfig['$db']) ? $this->allConfig['$db'] : [];
        }

        if(is_readable($this->cliConfPath)) {
            $this->cliConf = include $this->cliConfPath;
            if (!is_array($this->cliConf)) {
                $this->cliConf = [];
            }
        }
    }

    /**
     * gets global config
     *
     * @return mixed
     */
    public function getGlobalConfig()
    {
        return $this->globalConfig;
    }

    /**
     * Searches for the given parameter and returns its value if found else returns null
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->globalConfig)) {
            return $this->globalConfig[$name];
        } elseif (array_key_exists($name, $this->routesConfig)) {
            return $this->routesConfig[$name];
        } else {
            return false;
        }
    }

    /**
     * Store new params to file
     *
     * @param $arr
     * @param $filePath
     * @return bool
     */
    public function store($arr, $filePath)
    {
        if (!is_array($arr)) {
            $arr = [];
        }

        chmod($filePath, 0777);
        if (is_readable($filePath)) {
            $orgData = file_get_contents($filePath);
        } else {
            $orgData = [];
        }

        $newArr = array_merge($orgData, $arr);
        $data = '<?php return ' . var_export($newArr, true) . ";\n ?>";
        file_put_contents($filePath, $data);
        return chmod($filePath, 0655);
    }


    public static function save(array $arr, $file = null)
    {
        $fileContents = [];
        if (empty($arr)) {
            throw new \ErrorException("Nothing to save!");
        }

        if (is_null($file)) {
            $file = self::$globalPath;
            $fileContents = self::$global;
        } elseif (is_readable($file)) {
            $fileContents = include $file;
        }

        foreach($arr as $k => $v) {
            $fileContents[$k] = $v;
        }

        try {
            chmod($file, 0777);
            $data = '<?php return ' . var_export($fileContents, true) . ";\n ?>";
            file_put_contents($file, $data);
            chmod($file, 0655);
        } catch (\Exception $e) {
            throw new \ErrorException("Unable to write to save config! -" . $e->getMessage());
        }

        return true;
    }

    /**
     * Set/add config data
     *
     * @param string $name
     * @param mixed $val
     */
    public function __set($name, $val)
    {
        $this->globalConfig[$name] = $val;
    }

    /**
     * get routes config
     *
     * @return mixed
     */
    public function getRoutesConfig()
    {
        return $this->routesConfig;
    }

    /**
     * @param $name
     * @param $val
     */
    public function setCliConfig($name, $val)
    {
        $this->cliConf[$name] = $val;
        $this->store($this->cliConf, $this->cliConfPath);
    }

    /**
     * Add parameter to global conf array
     *
     * @param $name
     * @param $val
     */
    public function addToGlobalConfig($name, $val) {
        $this->globalConfig[$name] = $val;
    }

    /**
     * @return mixed
     */
    public function getCliConfig()
    {
        return $this->cliConf;
    }

    // TODO : integrate the below function into config class for dot(.) based array access
    /**
     * Allows the use of dot separated array key access
     *
     * @param $arr
     * @param $path
     * @param $value
     */
    private function assignArrayByPath(&$arr, $path, $value)
    {
        $keys = explode('.', $path);

        while ($key = array_shift($keys)) {
            $arr = &$arr[$key];
        }

        if (is_array($arr)) {
            array_push($arr, $value);
        } else {
            $arr = $value;
        }
    }

}
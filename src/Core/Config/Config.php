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
    /**
     * @var array Global configurations
     */
    private $globalConfig;
    /**
     * @var string Global config file path
     */
    public $globalConfPath;
    /**
     * @var array Routes Configurations
     */
    private $routesConfig;

    /**
     * Constructor to load configurations
     */
    public function __construct()
    {
        $this->globalConfPath = $globalConf = _APPDIR . DS . "config" . DS . "global.conf.php";
        $routeConf = _APPDIR . DS . "config" . DS . "routes.conf.php";

        $this->globalConfig = include $globalConf;
        $this->routesConfig = include $routeConf;
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
     * @param $name
     * @param $val
     * @return int
     */
    public function store($name, $val)
    {
        $this->globalConfig[$name] = $val;
        $globalConfig = $this->globalConfig;
        chmod($this->globalConfPath, 0777);
        $data = '<?php return ' . var_export($globalConfig, true) . ";\n ?>";
        $r = file_put_contents($this->globalConfPath, $data);
        chmod($this->globalConfPath, 0655);
        return $r;
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

}
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
    private static $globalConfig;
    /**
     * @var array Routes Configurations
     */
    private static $routesConfig;
    /**
     * @var Config Instance of the Config Class
     */
    private static $instance;

    /**
     * Constructor to load configurations
     */
    protected function __construct()
    {
        $globalConf = _ROOT . DS . "config" . DS . "global.conf.php";
        $routeConf = _ROOT . DS . "config" . DS . "routes.conf.php";

        self::$globalConfig = include $globalConf;
        self::$routesConfig = include $routeConf;
    }


    public static function getInstance()
    {
        if (null === self::$instance) {
           self::$instance = new Config();
        }

        return self::$instance;
    }

    /**
     * gets global config
     *
     * @return mixed
     */
    public static function getGlobalConfig()
    {
        return self::$globalConfig;
    }

    /**
     * Searches for the given parameter and returns its value if found else returns null
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, self::$globalConfig)) {
            return self::$globalConfig[$name];
        } elseif (array_key_exists($name, self::$routesConfig)) {
            return self::$routesConfig[$name];
        } else {
            return null;
        }
    }

    /**
     * Set/add config data
     *
     * @param string $name
     * @param mixed $arr
     */
    public function __set($name, $arr)
    {
        self::$globalConfig->$name = $arr;
    }

    /**
     * get routes config
     *
     * @return mixed
     */
    public static function getRoutesConfig()
    {
        return self::$routesConfig;
    }

}
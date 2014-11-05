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
class config
{

    private $globalConfig;
    private $routesConfig;

    /**
     * Constructor to load configurations
     */
    public function __construct()
    {
        $globalConf = _ROOT . DS . "config" . DS . "global.conf.php";
        $routeConf = _ROOT . DS . "config" . DS . "routes.conf.php";

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
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->globalConfig)) {
            return $this->globalConfig[$name];
        } elseif (array_key_exists($name, $this->routesConfig)) {
            return $this->routesConfig[$name];
        } else {
            return null;
        }
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
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

namespace Core\Controllers;


use Core\Application\Application;
use Core\Application\CoreApp;
use Core\Routes\Router;
use Core\Views\AppView;

/**
 * Class BaseController
 * @package Core\Controllers
 */
class BaseController
{

    /**
     * Router object
     *
     * @var Router
     */
    public $router;

    /**
     * AppView object
     *
     * @var AppView
     */
    public $view;

    /**
     * Application configuration
     *
     * @var Array
     */
    public $conf;

    /**
     * Application base/core path
     *
     * @var null | string
     */
    public $basePath;

    /**
     * Application folder path
     *
     * @var null | string
     */
    public $appPath;

    /**
     * Sanitized $_POST parameter
     *
     * @var array
     */
    public $POST;

    /**
     * Sanitized $_GET parameters
     *
     * @var array
     */
    public $GET;

    /**
     * Request Method
     *
     * @var string
     */
    public $method;

    /**
     * CSRF string
     *
     * @var string
     */
    public $csrf;

    /**
     * @param Router $router
     * @param AppView $view
     * @param array $conf
     */
    function __construct(Router $router, AppView $view, $conf = [])
    {
        $this->router = $router;
        $this->view = $view;
        $this->conf = $conf;
        $this->basePath = isset($this->conf['$global']['basePath']) ? $this->conf['$global']['basePath'] : null;
        $this->appPath = isset($this->conf['$global']['appPath']) ? $this->conf['$global']['appPath'] : null;

        $this->POST = &$router->POST;
        $this->GET = &$router->GET;
        $this->method = &$router->method;

        $this->baseInit();
    }


    /**
     * Base init
     */
    private function baseInit()
    {
        $conf = $this->conf;
        $routeParams = $this->router->routeVars;

        if (CoreApp::$app->_DEBUG === true) {
            $this->view->setDebugMode(true);
        } else {
            $this->view->setDebugMode(false);
        }

        $this->generateCSRFKey();

        $pageTitle = isset($routeParams['pageTitle']) ? $routeParams['pageTitle'] : '';
        $this->view->setTemplateVars('title', $pageTitle);

        if (isset($routeParams['pageName'])) {
            $this->view->setTemplateVars('pageName', $routeParams['pageName']);
        }

        if ((isset($conf['$global']['metaAndTitleFromFile']) &&
                $conf['$global']['metaAndTitleFromFile'] === true) ||
            (isset($routeParams['metaAndTitleFromFile']) &&
                $routeParams['metaAndTitleFromFile'] === true)
        ) {
            $metaFilePath = isset($conf['$global']['metaFile']) ? $conf['$global']['metaFile'] :
                isset($routeParams['metaFile']) ? $routeParams['metaFile'] : "";
            $metaPath = $conf['$global']['appPath'] . DS . ltrim($metaFilePath, "/");
            if (is_readable($metaPath)) {
                $metaContent = include($metaPath);
                $metas = isset($metaContent[$this->router->path]) ? $metaContent[$this->router->path] : '';
            } else {
                trigger_error(
                    htmlentities("{$conf['$global']['mataFile']} file not found or is not readable"),
                    E_USER_WARNING
                );
            }

        } else {
            $metas = isset($routeParams['metas']) ? $routeParams['metas'] : '';
        }

        if (!empty($metas)) {

            if (isset($metas['pageTitle'])) {
                $this->view->setTemplateVars('title', $metas['pageTitle']);
                unset($metas['pageTitle']);
            }

            $this->view->tplInfo['vars']['metas'] = $metas;
        }

    }

    /**
     * Generates CSRF key
     *
     */
    private function generateCSRFKey()
    {
        $key = sha1(microtime());
        $this->csrf = $_SESSION['csrf'] = empty($_SESSION['csrf']) ? $key : $_SESSION['csrf'];
        $this->view->setTemplateVars('csrf', $this->csrf);
    }

    /**
     * Default method for template rendering
     *
     * @return array
     */
    public function indexAction()
    {
        $this->view->tplInfo['tpl'] = 'homepage/home.tpl';
    }


    /**
     * Makes string UTF-8 compliant
     *
     * @param $d
     * @return array|string
     */
    public function utf8ize($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = $this->utf8ize($v);
            }
        } else if (is_string ($d)) {
            return utf8_encode($d);
        }
        return $d;
    }


    /**
     * Resets Application Cache
     *
     * @throws \ErrorException
     */
    public function resetCache()
    {
        $routes = $this->conf['$routes'];
        /** @var \Core\CacheSystem\BaseCache $cache */
        $cache = Application::get('Cache');

        foreach($routes as $route => $params) {
            $key = md5($route . '_view_' . session_id());
            $cache->deleteCache($key);
        }

    }


    /**
     * Outputs json (response) for given array
     *
     * @param array $jsonArr
     */
    public function sendJson(array $jsonArr)
    {
        ob_start();

        if (!headers_sent()) {
            header('Content-Type: application/json; charset: UTF-8');
            header('Cache-Control: must-revalidate');
        } else {
            trigger_error('Headers set before calling baseController::sendJson');
        }

        $json = json_encode($jsonArr);
        echo $json;

        ob_end_flush();
    }

}
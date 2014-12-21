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

use Core\Config\Config;
use Core\Models;
use Core\Routes\Routes;
use Core\Views\view;

/**
 * The base controller for Core Framework
 *
 * @package Core\Controllers
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class Controller
{
    public $view;
    public $config;
    protected $route;
    public $response;
    public $err404Tpl = "errors/404.tpl";
    private $controller;
    private $method;
    private $args;
    private $modelName;
    private $model;
    private $routeParams;
    private $req;
    public  $getVars;
    public  $postVars;
    public  $server;
    private $modelDir;
    private $defaultTpl = 'homepage/home.tpl';
    private $illegal = [
        '$',
        '*',
        '\'',
        '<',
        '>',
        '^',
        '(',
        ')',
        '[',
        ']',
        '\\',
        '/',
        '!',
        '~',
        '`',
        '{',
        '}',
        '|',
        '?php',
        'script'
    ];

    /**
     * instantiates Controller object from route vars
     *
     * @param Routes $route
     * @param view $view
     * @param config $config
     */
    public function __construct(Routes $route, View $view, Config $config) {

        $this->route = $route;
        $this->view = $view;
        $this->config = $config;

        $this->controller = $this->route->getController();
        $this->method = $this->route->getRqstMethod();
        $this->args = $this->route->getArgs();
        $this->routeParams = $this->route->getRouteVars();
        $this->getVars = $this->route->getGetVars();
        $this->postVars = $this->route->getPostVars();
        $this->server = $this->route->getServer();
        $this->checkForInput();
        $this->initResponse();
        $model = $this->route->getModel();
        if (!empty($model)) {
            $this->modelName = $modelName = $this->route->getModel();
            $this->model = new $modelName();
        }
        if (!empty($req)) {
            $this->req = $this->route->getRequired();
        }
    }

    /**
     * check for input (support for angular POST)
     *
     */
    private function checkForInput()
    {
        $postdata = file_get_contents("php://input");
        if ($postdata) {
            $postdata = $this->inputSanitize($postdata);
            $this->postVars['json'] = json_decode($postdata);
        }
    }

    /**
     * Sanitize inputs
     *
     * @param $data
     * @return array
     */
    private function inputSanitize($data)
    {
        $sanitizedData = [];
        foreach ($data as $key => $val) {
            switch ($key) {
                case 'email':
                    $sanitizedData[$key] = htmlentities(filter_var($val, FILTER_SANITIZE_EMAIL));
                    break;

                case 'phone':
                case 'mobile':
                    $sanitizedData[$key] = htmlentities(filter_var($val, FILTER_SANITIZE_NUMBER_INT));
                    break;

                default:
                    $sanitizedData[$key] = htmlentities(filter_var($val, FILTER_SANITIZE_STRING));
                    break;
            }
        }
        str_replace($this->illegal, '', $sanitizedData);

        return $sanitizedData;
    }

    /**
     * Init view response
     *
     */
    private function initResponse()
    {
        $params = $this->routeParams;
        $this->generateCSRFKey();
        $this->view->tplInfo['vars']['title'] = isset($params['pageTitle']) ? $params['pageTitle'] : '';
        $this->view->tplInfo['vars']['pageName'] = isset($params['pageName']) ? $params['pageName'] : '';
        $this->view->tplInfo['vars']['metas']['keywords'] = isset($params['metaKeywords']) ? $params['metaKeywords'] : '';
        $this->view->tplInfo['vars']['metas']['description'] = isset($params['metaDescription']) ? $params['metaDescription'] : '';
        $this->view->tplInfo['vars']['metas']['author'] = "Shalom Sam";
        $this->view->tplInfo['vars']['csrf'] = $_SESSION['csrf'];
    }

    /**
     * Generates CSRF key
     *
     */
    private function generateCSRFKey()
    {
        $key = sha1(microtime());
        $_SESSION['csrf'] = empty($_SESSION['csrf']) ? $key : $_SESSION['csrf'];
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
     * Returns the set Controller
     *
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns the model name set in route.conf
     *
     * @return null if null or mixed
     */
    public function getModelName()
    {
        return $this->modelName;
    }

    /**
     * Returns the model object, that is auto loaded if set in route.conf
     *
     * @return object model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Returns the method name set in route.conf
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Returns the parameters(as arguments) from the URL path in dynamic URLs set in route.conf
     *
     * @return null if null or mixed
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Returns required classes to load
     *
     * @return null if null or mixed
     */
    public function getReq()
    {
        return $this->req;
    }

    /**
     * returns sanitized $_GET
     *
     * @return array
     */
    public function getGetVars()
    {
        return $this->getVars;
    }

    /**
     * returns sanitized $_POST
     *
     * @return array
     */
    public function getPostVars()
    {
        return $this->postVars;
    }

    /**
     * Returns Server details
     *
     * @return array
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * returns route parameters
     *
     * @return array
     */
    public function getRouteParams()
    {
        return $this->routeParams;
    }

    /**
     * loads required files
     */
    public function loadReq()
    {
        $req = $this->req;
        if (sizeof($req['php']) != 0) {
            foreach ($req['php'] as $filepath) {
                $this->__fileLoad(_ROOT . $filepath);
            }
        }
    }

    /**
     * Loads the file into Core Framework
     *
     * @param $file
     * @return bool
     */
    private function __fileLoad($file)
    {
        if (file_exists($file)) {
            require_once $file;
        } else {
            return false;
        }
    }

    /**
     * auto loader for required classes
     *
     * @param $model
     * @return bool false if file does not exist;
     */
    private function __autoload($model)
    {
        $file = _ROOT . DS . "Core " . DS . "Models" . DS . $model . ".php";

        $elsefile = _ROOT . $this->modelDir . $model . ".php";

        $loaded = $this->__fileLoad($file);
        if (!$loaded) {
            return false;
        }
    }

    /**
     * loads required methods of loaded files
     */
    private function loadReqMethod()
    {
        $req = $this->req;
        if (sizeof($req['autoLoad']) != 0) {
            $method = $req['autoLoad']['method'];
            if (sizeof($req['autoLoad']['args']) != 0) {

                $args = "";
                foreach ($req['autoLoad']['args'] as $key => $val) {

                    if ($key === key($req['autoLoad']['args'])) {
                        $args .= $val;
                    } else {
                        $args .= $val . ",";
                    }
                }

                $method($args);

            } else {
                $method();
            }
        }
    }

}
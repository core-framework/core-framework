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

namespace Core\Routes;


use Core\CacheSystem\Cacheable;
use Core\Request\Request;

/**
 * Class Router
 * @package Core\Routes
 */
class Router extends Request implements Cacheable
{

    /**
     * @var string The path/query string of the request
     */
    public $path;
    /**
     * @var array The path represented as an array split at '/', .i.e. /some/path would be ['some','path']
     */
    public $urlPathArr = [];
    /**
     * @var string The string that defines the Controller and Method associated with a given URL path, extracted from the route.conf
     */
    public $controllerVerb;
    /**
     * @var array Contains the array of the parameters set for a given path in the routes.conf file
     */
    public $routeVars;
    /**
     * Use Aesthetic Routing i.e if set to true route conf will not be taken into consideration and requested URI will determine the controller, like so - {baseWebsiteURI}/{Controller}/{method}/{arguments}
     *
     * @var bool
     */
    public $useAestheticRouting = false;
    /**
     * If a match for current requested Route (URI) was found
     *
     * @var bool
     */
    public $foundMatch = false;
    /**
     * Response array
     *
     * @var array
     */
    public $response = [];
    /**
     * Defined HTTP method
     *
     * @var string
     */
    public $definedMethod;
    /**
     * To serve html as is. For static site(s)/page(s)/content(s)
     *
     * @var bool
     */
    public $customServe;
    /**
     * Reference Path to the folder to serve as static content
     *
     * @var string
     */
    public $referencePath;
    /**
     * namespace strings
     *
     * @var string
     */
    public $namespace;
    /**
     * controller name
     *
     * @var string
     */
    public $controller;
    /**
     * method name
     *
     * @var string
     */
    public $method;
    /**
     * Arguments passed by the route
     *
     * @var array
     */
    public $args;
    /**
     * model name
     *
     * @deprecated Deprecated since version 3.0.0
     * @var string
     */
    public $model;
    /**
     * Requested filename
     *
     * @var string
     */
    public $fileName;
    /**
     * Requested file extension
     *
     * @var string
     */
    public $fileExt;
    /**
     * Global ($global) config
     *
     * @var array
     */
    public $global;
    /**
     * @var
     */
    public $resolvedArr;
    /**
     * @var array
     */
    public $config;
    /**
     * @var array Contains a collection of the defined routes in route.conf
     */
    private $collection;

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        parent::__construct($config);
        $this->path = $this->getPath();
        $this->pathBurst();
        $this->loadRoutesConf($config);
    }


    /**
     * build the urlPathArr prop
     */
    private function pathBurst()
    {
        $path = $this->path;
        if (empty($path)) {
            $this->urlPathArr = ['/'];
        } else {
            $this->urlPathArr = explode('/', $path);
            $last_string = end($this->urlPathArr);
            if (strpos($last_string, ".") > -1) {
                $pi = pathinfo($last_string);
                $this->fileName = $pi['filename'];
                $this->fileExt = $pi['extension'];
            }
        }
    }

    /**
     * Loads the router config
     *
     * @param array $config
     */
    private function loadRoutesConf(&$config = [])
    {
        if (empty($config['$routes']) ||
            (isset($config['$global']['useAestheticRouting']) &&
                $config['$global']['useAestheticRouting'] === true)
        ) {
            $this->useAestheticRouting = true;
        } else {
            $this->collection = $config['$routes'];
            $this->global = $config['$global'];
        }

    }

    /**
     * @param bool $useAestheticRouting
     * @return array
     * @throws \ErrorException
     */
    public function resolve($useAestheticRouting = false)
    {
        if (!empty($this->resolvedArr)) {
            return $this->resolvedArr;
        }

        if (empty($this->path)) {

            $this->pathVarsAssign($this->collection['/']);

        } elseif ($useAestheticRouting === true) {

            $pathArr = explode("/", $this->path);

            $this->namespace = $namespace = '\\web\\Controllers';
            $this->routeVars = isset($this->config[$namespace . '\\' . $pathArr[1]]) ? $this->config[$namespace . '\\' . $pathArr[1]] : [];
            $this->controller = $pathArr[0] . 'Controller';
            $pathArr = array_shift($pathArr);
            $this->method = $pathArr[0] . 'Action';
            $pathArr = array_shift($pathArr);
            $this->args = $pathArr;

        } else {

            $this->checkIfPatternMatch();

            if ($this->foundMatch === false) {
                $this->namespace = '\\Core\\Controllers';
                $this->controller = 'errorController';
                $this->method = 'indexAction';
            }

        }

        $this->resolvedArr = $resolvedArr = [
            'namespace' => &$this->namespace,
            'controller' => &$this->controller,
            'method' => &$this->method,
            'args' => &$this->args,
            'routeVars' => &$this->routeVars
        ];

        return $resolvedArr;
    }

    /**
     * Sets the Namespace | Controller | method for the path.
     * Throws an exception if controller definition is not found
     *
     * @param $val
     * @throws \ErrorException
     */
    private function pathVarsAssign($val)
    {
        //$this->setDefaultController();
        $urlPathArr = $this->urlPathArr;
        $this->routeVars = $val;
        $this->definedMethod = !empty($val['httpMethod']) ? strtolower($val['httpMethod']) : 'get';
        if (!empty($this->routeVars['model'])) {
            $this->model = $this->routeVars['model'];
        }

        if (isset($val['useAestheticRouting']) && $val['useAestheticRouting'] === true) {
            $this->namespace = '@appBase\\Controllers';
            $this->controller = $urlPathArr[0];
            $this->method = isset($urlPathArr[1]) ? $urlPathArr[1] : 'indexAction';
            if (sizeof($urlPathArr) > 2) {
                $this->args = array_slice($urlPathArr, 2);
            }
            return;
        }

        if (!empty($val['controller'])) {
            $controllerStr = $this->controllerVerb = $val['controller'];
            $strArr = explode(':', $controllerStr);
            if (!empty($strArr) && sizeof($strArr) >= 2) {
                $this->namespace = $strArr[0];
                $this->controller = $strArr[1];
                if (!empty($strArr[2])) {
                    $this->method = strpos($strArr[2], 'Action') < 0 ? $strArr[2] . "Action" : $strArr[2];
                } elseif (empty($strArr[2]) && !empty($urlPathArr[1]) && !is_numeric(
                        $urlPathArr[1]
                    ) && !in_array($urlPathArr[1], $this->args)
                ) {
                    $this->method = $urlPathArr[1] . "Action";
                } else {
                    $this->method = "indexAction";
                }
            } elseif (empty($strArr) && $val['serveAsIs'] === false) {

                throw new \ErrorException(
                    "Controller not defined OR definition broken. Must be of pattern `{namespace}:{controller}:{httpMethod}` ",
                    5,
                    1
                );
            }

        }

        if (!empty($val['serveAsIs']) && $val['serveAsIs'] === true) {
            $this->customServe = true;
            $this->referencePath = $val['referencePath'];

            return;
        }

    }

    /**
     *  check if URL (path) matches defined paths (pathConf file)
     */
    public function checkIfPatternMatch()
    {
        $collection = $this->collection;
        $foundMatch = &$this->foundMatch;
        foreach ($collection as $key => $val) {
            $path = $this->path;
            $key = ltrim($key, '/');
            $path = rtrim($path, '/');

            if (!empty($key) && ($foundMatch != true)) {
                $keyArr = explode('/', $key);
                $newkey = implode('\/', $keyArr);
                $argReq = !empty($val['argReq']) ? $val['argReq'] : '[\w]';
                $argDflt = empty($val['argDefault']) ? null : $val['argDefault'];

                if ($path === $key) {
                    $foundMatch = true;
                    $this->pathVarsAssign($val);

                } elseif (preg_match_all('/\{(\w+)\}/', $newkey, $matches)) {
                    $regExKey = "";
                    $regExKey2 = "";
                    $argKey = "";
                    if (sizeof($matches[1]) > 1) {
                        $tempKey1 = $newkey;
                        foreach ($matches[1] as $i => $v) {
                            $argKey[$i] = $matches[1][$i];
                            if ($i === (sizeof($matches[1]) - 1)) {
                                $regExKey = preg_replace(
                                    '/\{' . $v . '\}/',
                                    '((' . $argReq[$v] . '+)(.html)?)',
                                    $tempKey1
                                );
                            } else {
                                $regExKey = preg_replace('/\{' . $v . '\}/', '(' . $argReq[$v] . '+)', $tempKey1);
                            }
                            $tempKey1 = $regExKey;
                        }
                        $regExKey2 = substr($regExKey, 0, strrpos($regExKey, "\\/"));
                    } else {
                        $argKey = $matches[1][0];
                        $regExKey = preg_replace('/\{(\w+)\}/', '((' . $argReq[$argKey] . '+)(.html)?)', $newkey);
                        $regExKey2 = rtrim(preg_replace('/\{(\w+)\}/', '', $newkey), "\\/");
                    }

                    $arrKey = "/^" . $regExKey . "$/";
                    $arrKey2 = "/^" . $regExKey2 . "$/";

                    //if has slug match pattern with current path
                    if (!empty($regExKey) && preg_match($arrKey, $path, $matches)) {
                        if (is_array($argKey)) {

                            foreach ($argKey as $i => $j) {

                                if ($argReq[$argKey[$i]] === '[\d]') {
                                    $this->args[$argKey[$i]] = (int)$matches[$i + 1];
                                } else {
                                    $this->args[$argKey[$i]] = $matches[$i + 1];
                                }

                            }

                        } else {
                            if ($argReq === '[\d]') {
                                $this->args[$argKey] = (int)$matches[1];
                            } else {
                                $this->args[$argKey] = $matches[1];
                            }

                        }
                        $foundMatch = true;
                        $this->pathVarsAssign($val);
                    }
                    //if doesnt have slug check if matches pattern(without slug) to current path
                    //and assign default value if match
                    elseif (!empty($regExKey2) && preg_match($arrKey2, $path, $matches)) {

                        if (is_array($argKey)) {

                            foreach ($matches as $i => $j) {

                                if ($argReq[$argKey[$i]] === '[\d]') {
                                    $this->args[$argKey[$i]] = (int)$matches[$i + 1];
                                } else {
                                    $this->args[$argKey[$i]] = $j;
                                }

                            }

                            end($argKey);
                            $k = key($argKey);
                            if ($argReq[$argKey[$k]] === '[\d]') {
                                $this->args[$argKey[$k]] = (int)$val['argDefault'][$argKey[$k]];
                            } else {
                                $this->args[$argKey[$k]] = $val['argDefault'][$argKey[$k]];
                            }


                        } else {
                            if ($argReq === '[\d]') {
                                $this->args[$argKey] = (int)$val['argDefault'];
                            } else {
                                $this->args[$argKey] = $val['argDefault'];
                            }
                        }
                        $foundMatch = true;
                        $this->pathVarsAssign($val);
                    }
                }
            }

        }
    }

    /**
     * Sleep magic method
     *
     * @return array
     */
    public function __sleep()
    {
        $routerSleep = [
            'path',
            'urlPathArr',
            'controllerVerb',
            'routeVars',
            'collection',
            'useAestheticRouting',
            'foundMatch',
            'response',
            'definedMethod',
            'customServe',
            'referencePath',
            'namespace',
            'controller',
            'method',
            'args',
            'model',
            'fileName',
            'fileExt',
            'global',
            'resolvedArr',
            'config'
        ];

        return $routerSleep;
    }

    /**
     * Magic wakup method. Initializes on unserialize
     */
    public function __wakeup()
    {

    }
}
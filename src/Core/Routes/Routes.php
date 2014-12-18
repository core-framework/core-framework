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

use Core\CacheSystem\Cachable;
use Core\Config\Config;
use Core\Request\Request;

/**
 * Handles the routing for the incoming request
 *
 * @package Core\Routes
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class Routes implements Cachable
{
    /**
     * @var string The path/query string of the request
     */
    public $path = "";
    /**
     * @var array The path represented as an array split at '/', .i.e. /some/path would be ['some','path']
     */
    public $urlPathArr = [];
    /**
     * @var string The string that defines the Controller and Method associated with a given URL path, extracted from the route.conf
     */
    public $controllerVerb;
    /**
     * @var Request Request object
     */
    protected $request;
    /**
     * @var Config Config object
     */
    protected $config;
    /**
     * @var array Contains the array of the parameters set for a given path in the routes.conf file
     */
    private $routeVars;
    /**
     * @var string Contains the requested file name if present in the URL path
     */
    private $fileName = "";
    /**
     * @var string Contains the requested file extension if the request was for a file
     */
    private $fileExt = "";
    /**
     * @var array Contains a collection of the defined routes in route.conf
     */
    private $collection;
    /**
     * @var array Contains an array of required classes defined in the routes.conf file
     */
    private $require;
    /**
     * @var string Contains the namespace of the controller class file
     */
    private $namespace;
    /**
     * @var string Contains the name of the controller class
     */
    private $controller;
    /**
     * @var string Contains the method/function name
     */
    private $method;
    /**
     * @var string Contains the name of the model to be autoloaded in the controller
     */
    private $model;
    /**
     * @var array Is an array of folder names used to serve front end content
     */
    private $FEComponents = ['scripts', 'images', 'js', 'styles'];
    /**
     * @var bool Defines whether to serve url path as a micro-site devoid of templating(controller may or may not be defined). This is defined in the routes.conf
     */
    private $customServe;
    /**
     * @var string Contains the real path to folder to be served as a micro-site (html/css/js only)
     */
    private $referencePath;
    /**
     * @var array Contains the arguments to be passed to the controller method from the dynamic URL path variable
     */
    private $args;
    /**
     * @var bool Defines if the current request is for a root file .i.e domain.com/somefile.txt
     */
    private $isRootFile;
    /**
     * @var bool Defines if the current request is for a front-end component (.i.e. CSS/JS)
     */
    private $isFEComponent;
    /**
     * @var bool Defines if a match was found for the current URL path (in the request) in the routes.conf
     */
    private $foundMatch = false;
    /**
     * @var string The method filter/constraint defined for the current path in routes.conf
     */
    private $definedMethod = 'get';

    /**
     * Sets $this properties
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->templatePath = DS . "Templates" . DS;
        $this->request = $request;
        $this->path = $request->getPath();
        $this->checkforTrailingSlashes();
        $this->pathBurst();
        $this->loadRoutesConf();
    }


    /**
     * all URLs with trailing slash is redirected to same URL with trailing slash(/) stripped
     */
    private function checkforTrailingSlashes()
    {
        $path = $this->path;
        if ($path[strlen($path) - 1] === '/') {
            $newpath = rtrim($path, '/');
            header('Location: /' . $newpath);
            die();
        }
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
            $this->urlPathArr = explode("/", $path);
            $last_string = end($this->urlPathArr);
            if (strpos($last_string, ".") > -1) {
                $pi = pathinfo($last_string);
                $this->fileName = $pi['filename'];
                $this->fileExt = $pi['extension'];
            } else {
                $this->frontController = $this->urlPathArr[0];
            }
        }
    }

    /**
     * loads the pathConf file. Thows an exception if file is not found or not readable
     *
     * @throws \ErrorException
     */
    private function loadRoutesConf()
    {
        $this->collection = Config::getRoutesConfig();
    }

    /**
     * find controller and methods for current URL (path)
     */
    public function findMatch()
    {
        if (empty($this->path)) {

            $this->pathVarsAssign($this->collection['/']);

        } elseif (in_array($this->urlPathArr[0], $this->FEComponents)) {

            $this->isFEComponent = true;

        } elseif (!empty($this->fileExt) && !empty($this->fileName) && sizeof($this->urlPathArr) === 1) {

            $file = $this->fileName . "." . $this->fileExt;
            $filePath = _ROOT . $this->templatePath . "root" . DS . $file;
            $is_readable = is_readable($filePath);
            if (($this->urlPathArr[0] === $file)) {
                $this->isRootFile = true;
                if (!$is_readable) {

                }
            }

        } else {

            $this->checkIfPatternMatch();
            if ($this->foundMatch === false) {

                $this->header = '404';
                $this->controller = 'errorController';
                $this->method = 'indexAction';

            }

        }
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
        $this->setDefaultController();
        $this->routeVars = $val;
        if (!empty($val['serveAsIs']) && $val['serveAsIs'] === true) {
            $this->customServe = true;
            $this->referencePath = $val['referencePath'];
        }

        if (!empty($val['controller'])) {
            $this->definedMethod = !empty($val['method']) ? strtolower($val['method']) : 'get';
            $controllerStr = $this->controllerVerb = $val['controller'];
            $strArr = explode(':', $controllerStr);
            if (!empty($strArr) && sizeof($strArr) >= 2) {
                $this->namespace = $strArr[0];
                $this->controller = $strArr[1];
                if (!empty($strArr[2])) {
                    $this->method = strpos($strArr[2], 'Action') < 0 ? $strArr[2] . "Action" : $strArr[2];
                } elseif (empty($strArr[2]) && !empty($this->urlPathArr[1]) && !is_numeric(
                        $this->urlPathArr[1]
                    ) && !in_array($this->urlPathArr[1], $this->args)
                ) {
                    $this->method = $this->urlPathArr[1] . "Action";
                } else {
                    $this->method = "indexAction";
                }
            } elseif (empty($strArr) && $val['serveAsIs'] === false) {

                throw new \ErrorException(
                    "Controller not defined OR definition broken. Must be of pattern `{namespace}:{controller}:{method}` ",
                    5,
                    1
                );
            }
        }
        if (!empty($this->routeVars['model'])) {
            $this->model = $this->routeVars['model'];
        }
        if (!empty($this->routeVars['require'])) {
            $this->require = $this->routeVars['require'];
        }
    }

    /**
     * Extracts the default Controller from root path ('/')
     */
    private function setDefaultController()
    {
        $controllerVerb = $this->collection['/']['controller'];
        $arr = explode(':', $controllerVerb);
        $this->defaultController = $arr[0] . "\\" . $arr[1];
    }

    /**
     *  check if URL (path) matches defined paths (pathConf file)
     */
    public function checkIfPatternMatch()
    {
        foreach ($this->collection as $key => $val) {
            $path = $this->path;
            $key = ltrim($key, '/');
            $path = rtrim($path, '/');
            //$foundMatch = $this->foundMatch;
            if (!empty($key) && ($this->foundMatch != true)) {
                $keyArr = explode('/', $key);
                $newkey = implode('\/', $keyArr);
                $argReq = !empty($val['argReq']) ? $val['argReq'] : '[\w]';
                $argDflt = empty($val['argDefault']) ? null : $val['argDefault'];

                if ($path === $key) {
                    $this->foundMatch = true;
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
                        $this->foundMatch = true;
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
                        $this->foundMatch = true;
                        $this->pathVarsAssign($val);
                    }
                }
            }

        }
    }

    /**
     * Returns the relative URL requested
     *
     * @return string
     */
    public function getPath()
    {
        return $this->request->getPath();
    }

    /**
     * Returns the current fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Returns the file extension
     *
     * @return string
     */
    public function getFileExt()
    {
        return $this->fileExt;
    }

    /**
     * Returns the namespace
     *
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * sets the namespace
     *
     * @param $str
     */
    public function setNamespace($str)
    {
        $this->namespace = $str;
    }

    /**
     * Returns the controller
     *
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * sets the controller
     *
     * @param $str
     */
    public function setController($str)
    {
        $this->controller = $str;
    }

    /**
     * get class method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * set class method
     *
     * @param $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * returns the method
     *
     * @return mixed
     */
    public function getRqstMethod()
    {
        return $this->request->getRqstMethod();
    }

    /**
     * sets the method
     *
     * @param $str
     */
    public function setRqstMethod($str)
    {
        $this->method = $str;
    }

    /**
     * Returns the arguments [array]
     *
     * @return mixed
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Returns the model
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Returns the required files
     *
     * @return mixed
     */
    public function getRequired()
    {
        return $this->require;
    }

    /**
     * Returns true if the file is a root file
     *
     * @return bool
     */
    public function getIsRootFile()
    {
        return $this->isRootFile;
    }

    /**
     * Returns true if the file Front End Component
     *
     * @return bool
     */
    public function getIsFEComponent()
    {
        return $this->isFEComponent;
    }

    /**
     * Returns true if the file is set as Custom serve (serveAsIs)
     *
     * @return mixed
     */
    public function getIsCustomServe()
    {
        return $this->customServe;
    }

    /**
     * returns reference path set in routes.conf
     *
     * @return mixed
     */
    public function getReferencePath()
    {
        return $this->referencePath;
    }

    /**
     * Returns the properties of the path
     *
     * @return array
     */
    public function getRouteVars()
    {
        return $this->routeVars;
    }

    /**
     * Add route vars
     *
     * @param array $arr
     */
    public function addRouteVars(array $arr)
    {
        $key = key($arr);
        $this->routeVars[$key] = $arr[$key];
    }

    /**
     * returns the sanitized $_GET
     *
     * @return array
     */
    public function getGetVars()
    {
        return $this->request->getGetVars();
    }

    /**
     * returns the sanitized $_POST
     *
     * @return array
     */
    public function getPostVars()
    {
        return $this->request->getPostVars();
    }

    /**
     * returns sanitized $_COOKIE
     *
     * @return array
     */
    public function getCookies()
    {
        return $this->request->getCookies();
    }

    /**
     * returns the current request method
     *
     * @return string
     */
    public function getReqstMethod()
    {
        return $this->request->getRqstMethod();
    }

    /**
     * returns the defined request method for the path
     *
     * @return string
     */
    public function getDefinedMethod()
    {
        return $this->definedMethod;
    }

    /**
     * Returns the Server details
     *
     * @return array
     */
    public function getServer()
    {
        return $this->request->getServer();
    }

    /**
     * Sleep magic method
     *
     * @return array
     */
    public function __sleep()
    {
        return [
            'path',
            'urlPathArr',
            'controllerVerb',
            'reqstMethod',
            'routeVars',
            'fileName',
            'fileExt',
            'collection',
            'require',
            'namespace',
            'controller',
            'method',
            'model',
            'FEComponents',
            'customServe',
            'referencePath',
            'args',
            'isRootFile',
            'isFEComponents',
            'foundMatch',
            'definedMatch',
            'definedMethod'
        ];
    }

    public function wakeUp($di)
    {

    }

} 

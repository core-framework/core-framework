<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 22/08/14
 * Time: 1:13 PM
 */

namespace Core\Routes;

use Core\Request\request;

class routes
{
    public $path = "";
    public $urlPathArr = [];
    public $controllerVerb;
    public $header;
    private $server;
    private $cookies;
    private $getVars = [];
    private $postVars = [];
    private $reqstMethod;
    private $pathConfFile;
    private $routeVars;
    private $fileName = "";
    private $fileExt = "";
    private $frontController;
    private $collection;
    private $require;
    private $namespace;
    private $controller;
    private $method;
    private $model;
    private $FEComponents = ['scripts', 'images', 'js', 'styles'];
    private $args;
    private $templatePath;
    private $isRootFile;
    private $isFEComponent;
    private $foundMatch = false;
    private $definedMethod = 'get';

    /**
     * Sets $this properties
     *
     * @param request $request
     */
    public function __construct(request $request)
    {
        $this->pathConfFile = DS . "config" . DS . "routes.conf.php";
        $this->templatePath = DS . "Templates" . DS;
        $this->path = $path = $request->getPath();
        $this->getVars = $request->getGetVars();
        $this->postVars = $request->getPostVars();
        $this->reqstMethod = $request->getRqstMethod();
        $this->server = $request->getServer();
        $this->cookies = $request->getCookies();
        $this->checkforTrailingSlashes();
        $this->pathBurst();
        $this->loadConfFile();
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
    private function loadConfFile()
    {
        $routes = include _ROOT . $this->pathConfFile;
        if (!empty($routes)) {
            $this->collection = $routes;
        } else {
            throw new \ErrorException("Routes conf file empty or broken", 0, 1, 'routes.php');
        }
    }

    /**
     * set the pathconf file dynamically
     *
     * @param $filepath
     */
    public function setConfFile($filepath)
    {
        $this->pathConfFile = $filepath;
        $this->loadConfFile();
    }

    /**
     * find controller and methods for current URL (path)
     */
    public function findMatch()
    {
        if (empty($this->path)) {
            $this->pathVarsAssign($this->collection['/']);
        } elseif (in_array($this->urlPathArr[0], $this->FEComponents)) {
            //var_dump('asdasd');
            $this->isFEComponent = true;
            //include_once _ROOT.$this->templatePath.ltrim($this->path, "/");
        } elseif (!empty($this->fileExt) && !empty($this->fileName) && sizeof($this->urlPathArr) === 1) {
            $file = $this->fileName . "." . $this->fileExt;
            $filePath = _ROOT . $this->templatePath . "root" . DS . $file;
            $is_readable = is_readable($filePath);
            if (($this->urlPathArr[0] === $file)) {
                $this->isRootFile = true;
                if(!$is_readable) {
                    //add warning
                }
            }
        } else {
            $this->checkIfPatternMatch();
            if ($this->foundMatch === false) {
                $this->header = '404';
                $this->controller = 'errorController';
                $this->method = 'indexAction';
//                $this->routeVars = [
//                    'pageName' => 'error',
//                    'pageTitle' => 'Oops something went wrong',
//                    'controller' => '\\Core\\Controllers:errorController:indexAction'
//                ];
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
        $this->routeVars = $val;
        $this->definedMethod = !empty($val['method']) ? strtolower($val['method']) : 'get';
        $controllerStr = $this->controllerVerb = $val['controller'];
        $strArr = explode(':', $controllerStr);
        if (!empty($strArr) && sizeof($strArr) >= 2) {
            $this->namespace = $strArr[0];
            $this->controller = $strArr[1];
            //$this->method = empty($strArr[2]) ? 'indexAction' ? ;
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
        } else {
            throw new \ErrorException("Controller not defined OR definition broken. Must be of pattern `{namespace}:{controller}:{method}` ", 5, 1);
        }
        if (!empty($this->routeVars['model'])) {
            $this->model = $this->routeVars['model'];
        }
        if (!empty($this->routeVars['require'])) {
            $this->require = $this->routeVars['require'];
        }
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
                $argDflt = $val['argDefault'];

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
     * Set Template Directory
     * @param $dir
     */
    public function setTemplateDir($dir)
    {
        $this->templatePath = $dir;
    }

    /**
     * Returns the current fileName
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Returns the file extension
     * @return string
     */
    public function getFileExt()
    {
        return $this->fileExt;
    }

    /**
     * Returns the namespace
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * sets the namespace
     * @param $str
     */
    public function setNamespace($str)
    {
        $this->namespace = $str;
    }

    /**
     * Returns the controller
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * sets the controller
     * @param $str
     */
    public function setController($str)
    {
        $this->controller = $str;
    }

    /**
     * returns the method
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * sets the method
     * @param $str
     */
    public function setMethod($str)
    {
        $this->method = $str;
    }

    /**
     * Returns the arguments [array]
     * @return mixed
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * Returns the model
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Returns the required files
     * @return mixed
     */
    public function getRequired()
    {
        return $this->require;
    }

    /**
     * Returns true if the file is a root file
     * @return bool
     */
    public function getIsRootFile()
    {
        return $this->isRootFile;
    }

    /**
     * Returns true if the file Front End Component
     * @return bool
     */
    public function getIsFEComponent()
    {
        return $this->isFEComponent;
    }

    /**
     * Returns the properties of the path
     * @return array
     */
    public function getRouteVars()
    {
        return $this->routeVars;
    }

    /**
     * returns the sanitized $_GET
     * @return array
     */
    public function getGetVars()
    {
        return $this->getVars;
    }

    /**
     * returns the sanitized $_POST
     * @return array
     */
    public function getPostVars()
    {
        return $this->postVars;
    }

    /**
     * returns the current request method
     * @return string
     */
    public function getReqstMethod()
    {
        return $this->reqstMethod;
    }

    /**
     * returns the defined request method for the path
     * @return string
     */
    public function getDefinedMethod()
    {
        return $this->definedMethod;
    }


} 
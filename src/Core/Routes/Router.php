<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 08/02/15
 * Time: 1:54 AM
 */

namespace Core\Routes;


use Core\CacheSystem\Cacheable;
use Core\Request\Request;

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
     * @var bool
     */
    public $useAestheticRouting = false;
    public $foundMatch = false;
    public $response = [];
    public $definedMethod;
    public $customServe;
    public $referencePath;
    public $namespace;
    public $controller;
    public $method;
    public $args;
    public $model;
    public $fileName;
    public $fileExt;
    public $global;
    public $resolvedArr;
    public $config;
    /**
     * @var array Contains a collection of the defined routes in route.conf
     */
    private $collection;

    public function __construct($config = [])
    {
        $this->config = $config;
        parent::__construct();
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

    public function resolve()
    {
        if (!empty($this->resolvedArr)) {
            return $this->resolvedArr;
        }

        if (empty($this->path)) {

            $this->pathVarsAssign($this->collection['/']);

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
        $this->definedMethod = !empty($val['method']) ? strtolower($val['method']) : 'get';
        if (!empty($this->routeVars['model'])) {
            $this->model = $this->routeVars['model'];
        }

        if (!empty($val['serveAsIs']) && $val['serveAsIs'] === true) {
            $this->customServe = true;
            $this->referencePath = $val['referencePath'];

            return;
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
                    "Controller not defined OR definition broken. Must be of pattern `{namespace}:{controller}:{method}` ",
                    5,
                    1
                );
            }

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

        //return array_merge(parent::__sleep(), $routerSleep);

        return $routerSleep;
    }

    /**
     * Magic wakup method. Initializes on unserialize
     */
    public function __wakeup()
    {

    }
}
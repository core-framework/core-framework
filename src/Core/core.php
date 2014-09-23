<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * @author Shalom Sam <shalom.s@coreframework.in>
 * Class core
 * @package Core
 */
class core
{
    public $controllerDir = [];
    public $modelDir = [];
    public $devMode = false;
    public $path;
    public $forceApc = false;
    private $templateDir;
    private $route;
    private $controller;
    private $modelName;
    private $view;
    private $templateInfo;
    private $getVars;
    private $postVars;
    private $cookies;
    private $validExtensions = [
        'js',
        'css',
        'html',
        'jpeg',
        'jpg',
        'gif',
        'png',
        'ico',
        'swf',
        'ttf',
        'woff',
        'svg',
        'php',
        'map'
    ];
    private $stylesDir;
    private $scriptsDir;
    private $imagesDir;
    private $resourcesDir;
    private $hasAPC;
    private $confFile;
    private $cacheTtl = 900; //15m

    /**
     * Initiates the core components
     */
    public function __construct($devMode = false)
    {
        $this->devMode = $devMode;

        $this->controllerDir[0] = DS . "src" . DS . "Core" . DS . "Controllers" . DS;
        $this->modelDir[0] = DS . "src" . DS . "Core" . DS . "Models" . DS;
        $this->confFile = DS . "config" . DS . "config.php";

        $apcisloaded = extension_loaded("apc");
        $apcisEnabled = ini_get('apc.enabled');
        $this->hasAPC = $apcisEnabled && $apcisloaded ? true : false;

        $req = new Request\request();
        $this->path = $req->getPath();
        $this->route = new Routes\routes($req);
        $this->view = new Views\view();

        spl_autoload_register([$this, 'autoloadController']);
        spl_autoload_register([$this, 'autoloadModel']);

        $getVars = $this->route->getGetVars();
        if ($getVars['action'] === 'clear_cache') {
            $this->clearCache();
        }
    }

    /**
     * Clear / reset APC Cache
     */
    private function clearCache()
    {
        apc_clear_cache();
    }

    /**
     * set the pathConf file (override defaults or previously set)
     * @param $file
     */
    public function setPathConfFile($file)
    {
        $this->route->setConfFile($file);
    }

    /**
     * run all Core components to produce output. Throws Exception if class or method is not found
     *
     * @throws \ErrorException
     */
    public function Load()
    {
        $path = $this->path;
        $pathVar = $path . "_view";
        $pathKey = md5($pathVar);
        if ($this->hasAPC && ($this->devMode || $this->forceApc)) {
            $hasKey = apc_exists($pathKey);
            if ($hasKey) {
                $this->view = apc_fetch($pathKey);
                $this->view->render();
            } else {
                $this->loadAll();
            }
        } else {
            $this->loadAll();
        }
    }

    /**
     * extended function
     * @throws \ErrorException
     */
    private function loadAll()
    {
        $path = $this->path;
        $pathVar = $path . "_route";
        $pathKey = md5($pathVar);
        $ttl = $this->cacheTtl;
        if ($this->hasAPC && ($this->devMode || $this->forceApc)) {
            $hasKey = apc_exists($pathKey);
            if ($hasKey) {
                $this->route = apc_fetch($pathKey);
            } else {
                $this->route->findMatch();
                apc_store($pathKey, $this->route, 2 * $ttl);
            }
        } else {
            $this->route->findMatch();
        }

        $this->getVars = $this->route->getGetVars();
        $this->postVars = $this->route->getPostVars();
        $this->cookies = $this->route->getCookies();
        $isFEComponent = $this->route->getIsFEComponent();
        $isRootFile = $this->route->getIsRootFile();
        $controller = $this->route->getController();
        $definedMethod = $this->route->getDefinedMethod();
        $reqstMethod = $this->route->getReqstMethod();
        $this->modelName = $this->route->getModel();

        //var_dump($controller);

        if ((empty($controller) && !$isFEComponent && !$isRootFile) || $definedMethod !== $reqstMethod) {
            $this->route->header = '404';
            $this->route->setController('errorController');
            $this->route->setMethod('pageNotFound');
        }

        if ($isRootFile) {
            $this->handleFEComponents(true);

        } elseif ($isFEComponent) {
            $this->handleFEComponents();

        } else {
            $this->view->debugMode($this->devMode);
            $controller = $this->route->getController();
            $namespace = $this->route->getNamespace();
            $namespace = empty($namespace) ? 'Controllers' : $namespace;
            $method = $this->route->getMethod();
            $method = empty($method) ? 'indexAction' : $method;
            $model = $this->modelName;
            $model = !empty($model) ? $model : null;
            $modelDir = $this->modelDir;
            $args = $this->route->getArgs();
            $args = !empty($args) ? $args : null;
            $required = $this->route->getRequired();
            $pageParams = $this->route->getRouteVars();
            $view = $this->view;

            $class = $namespace . "\\" . $controller;


            if (class_exists($class)) {
                $this->controller = new $class($controller, $method, $pageParams, $view, $this->postVars, $this->getVars, $modelDir, $model, $args, $required);
                if (method_exists($this->controller, $method) && $args != null) {
                    $this->templateInfo = $this->controller->$method($args);
                } else {
                    $this->templateInfo = $this->controller->$method();
                }
            } else {
                throw new \ErrorException("Class or Method not found", 11);
            }

            if ($this->view->disabled === false) {

                if (!empty($this->templateInfo['header'])) {
                    $this->setHeaders($this->templateInfo['header']);
                } else {
                    $header = $this->route->header;
                    $this->setHeaders($header);
                }

                $this->view->set('tplInfo', $this->templateInfo);

                $path = $this->path;
                $pathVar = $path . "_view";
                $pathKey = md5($pathVar);
                if ($this->hasAPC && ($this->devMode || $this->forceApc)) {
                    $hasKey = apc_exists($pathKey);
                    if ($hasKey) {
                        $this->view = apc_fetch($pathKey);
                    } else {
                        apc_store($pathKey, $this->view, $ttl);
                    }
                }

                $this->view->render();
            }
        }
    }

    /**
     * function to handle the Front End Components
     * @param bool $isRoot
     */
    private function handleFEComponents($isRoot = false)
    {
        $fileName = $this->route->getFileName();
        $fileExt = $this->route->getFileExt();
        $templateDir = $this->templateDir;
        $stylesDir = $this->stylesDir;
        $scriptsDir = $this->scriptsDir;
        $imagesDir = $this->imagesDir;
        $controller = "";
        $folder = "";
        $pathTpl = "";

        if ($isRoot) {
            $folder = DS . "root" . DS;
            $pathTpl = _ROOT . $templateDir . $folder . $fileName . "." . $fileExt;

        } elseif ($this->route->urlPathArr[0] === 'scripts') {

            if ($this->route->urlPathArr[1] === $fileName . "." . $fileExt) {
                $folder = "";
                $controller = $scriptsDir;
            } elseif ($this->route->urlPathArr[1] === 'base') {
                $folder = "";
                $controller = DS . "src" . DS . "Core" . DS . "Resources" . DS . "scripts" . DS;
            } else {
                $folder = $this->route->urlPathArr[1] . DS;
                $controller = $scriptsDir;
            }

            $pathTpl = _ROOT . $controller . $folder . $fileName . "." . $fileExt;

        } elseif ($this->route->urlPathArr[0] === 'styles') {

            if ($this->route->urlPathArr[1] === $fileName . "." . $fileExt) {
                $folder = "";
                $controller = $stylesDir;
            } elseif ($this->route->urlPathArr[1] === 'base') {
                $folder = "";
                $controller = DS . "src" . DS . "Core" . DS . "Resources" . DS . "styles" . DS;
            } else {
                $folder = $this->route->urlPathArr[1] . DS;
                $controller = $stylesDir;
            }

            $pathTpl = _ROOT . $controller . $folder . $fileName . "." . $fileExt;


        } elseif ($this->route->urlPathArr[0] === 'images') {
            if ($this->route->urlPathArr[1] === 'base') {
                $controller = DS . "src" . DS . "Core" . DS . "Resources" . DS . "images" . DS;
                $pathTpl = _ROOT . $controller . $fileName . "." . $fileExt;
            } else {
                $controller = $imagesDir;
                $pathTpl = _ROOT . $controller . $folder . $fileName . "." . $fileExt;
            }

        }

        $this->setHeaders($fileExt);

        include_once $pathTpl;
    }

    /**
     * Set header
     * @param null $type
     */
    private function setHeaders($type = null)
    {
        header('Cache-Control: max-age=3600');

        switch ($type) {
            case 'php':
            case 'html':
                header('Content-Type: text/html; charset=utf-8');
                break;

            case 'svg':
                header('Content-Type: image/svg+xml;');
                break;

            case 'jpeg':
            case 'jpg':
                header('Content-Type: image/jpeg');
                break;

            case 'png':
                header('Content-Type: image/png');
                break;

            case 'gif':
                header('Content-Type: image/gif');
                break;

            case 'ico':
                header('Content-Type: image/ico');
                break;

            case 'map':
            case 'javascript':
            case 'js':
                header('Content-Type: text/javascript;');
                break;

            case 'css':
                header('Content-Type: text/css;');
                break;

            case '404':
                header('HTTP/1.0 404 Not Found');
                break;

            default:
                //header('HTTP/1.0 404 Not Found');
                header('Content-Type: text;');
                //exit();
                break;
        }
    }

    /**
     * Set the cache TTL defaults
     * @param $sec
     */
    public function setCacheTtl($sec)
    {
        $this->cacheTtl = $sec;
    }

    /**
     * add public properties
     * @param $var
     * @param $val
     */
    public function add($var, $val)
    {
        $this->$var = $val;
    }

    /**
     * register application directories
     * @param $namespace
     * @param $appDir
     */
    public function registerApp($namespace, $appDir)
    {
        $this->addControllerDir($appDir . "Controllers" . DS);
        $this->addModelDir($appDir . "Models" . DS);
        $this->setResourcesDir($appDir);

        if ($this->devMode === true) {
            $whoops = new Run;
            $handler = new PrettyPageHandler;
            $whoops->pushHandler($handler);
            $whoops->register();
        }
    }

    /**
     * Add controllerDir to list
     * @param $path
     */
    public function addControllerDir($path)
    {
        array_push($this->controllerDir, $path);
    }

    /**
     * Add Model Dirs to list
     * @param $path
     */
    public function addModelDir($path)
    {
        array_push($this->modelDir, $path);
    }

    /**
     * set the resource directory. No need to set the images, scripts or styles directories individually if this
     * is set.
     *
     * @param $path
     */
    public function setResourcesDir($path)
    {
        $this->resourcesDir = $path;
        $this->setTemplateDir($path . "Templates" . DS);
        $this->setImagesDir($path . "images" . DS);
        $this->setScriptsDir($path . "scripts" . DS);
        $this->setStylesDir($path . "styles" . DS);
    }

    /**
     * set template directory (override defaults or previously set)
     * @param $dir
     */
    public function setTemplateDir($dir)
    {
        $this->templateDir = $dir;
        $this->view->setTemplateDir($dir);
        $this->route->setTemplateDir($dir);
    }

    /**
     * set the images directory
     * @param $path
     */
    public function setImagesDir($path)
    {
        $this->imagesDir = $path;
    }

    /**
     * set the scripts directory
     * @param $path
     */
    public function setScriptsDir($path)
    {
        $this->scriptsDir = $path;
    }

    /**
     * set the styles directory
     * @param $path
     */
    public function setStylesDir($path)
    {
        $this->stylesDir = $path;
    }

    /**
     * set controller directory
     * @param $path
     */
    public function setControllerDir($path)
    {
        array_push($this->controllerDir, $path);
    }

    /**
     * set the Model directory
     * @param $path
     */
    public function setModelDir($path)
    {
        array_push($this->modelDir, $path);
    }

    /**
     * autoloader to load controller files
     * @param $namespacedClass
     * @return bool
     */
    private function autoloadController($namespacedClass)
    {
        $arr = explode("\\", $namespacedClass);
        $first = $arr[0];
        $classname = end($arr);
        $found = false;

        $file = _ROOT . DS . strtr($namespacedClass, '\\', DS) . ".php";
        $elsefile = _ROOT . DS . "src" . DS . "Core" . DS . "Controllers" . DS . $classname . ".php";

        if (file_exists($file)) {
            require_once $file;
            $found = true;
        } elseif (file_exists($elsefile)) {
            require_once $elsefile;
            $found = true;
        } else {
            foreach ($this->controllerDir as $i => $val) {
                $file = _ROOT . $val . "Controllers" . DS . $classname . ".php";
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        }
    }

    /**
     * autoloader to load model files
     * @param $modelName
     * @return bool
     */
    private function autoloadModel($modelName)
    {
        $file = _ROOT . $this->modelDir . $modelName . ".php";
        //else check in Core
        $elsefile = _ROOT . DS . "src" . DS . "Core" . DS . "Models" . DS . $modelName . ".php";

        if (file_exists($file)) {
            require_once $file;
        } elseif (file_exists($elsefile)) {
            require_once $elsefile;
        } else {
            return false;
        }
    }
}
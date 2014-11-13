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

namespace Core;

use Core\CacheSystem\cache;
use Core\Request\request;
use Core\Routes\routes;
use Core\Views\view;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Core Kernel
 *
 * @package Core
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class core
{
    /**
     * @var array Controller directories
     */
    public $controllerDir = [];
    /**
     * @var array Model Directories
     */
    public $modelDir = [];
    /**
     * @var bool Development mode ( if set to true, disables APC and relies on internal caching )
     */
    public $devMode = false;
    /**
     * @var string Current URL path
     */
    public $path;
    /**
     * @var bool To force APC even if devMode is true ( considering that APC is available )
     */
    public $forceApc = false;
    /**
     * @var string Template directory
     */
    private $templateDir;
    /**
     * @var string Default/root template file
     */
    private $defaultTpl = "root.tpl";
    /**
     * @var string Default Controller
     */
    private $defaultController;
    /**
     * @var request Request object
     */
    private $request;
    /**
     * @var routes Routes object
     */
    private $route;
    /**
     * @var Controllers\controller
     */
    private $controller;
    /**
     * @var string Model ( class ) name
     */
    private $modelName;
    /**
     * @var view View object
     */
    private $view;
    /**
     * @var array Template information
     */
    private $templateInfo;
    /**
     * @var array Sanitized $_GET
     */
    private $getVars;
    /**
     * @var array Sanitized $_POST
     */
    private $postVars;
    /**
     * @var array Set Cookies
     */
    private $cookies;
    /**
     * @var array Valid Extensions
     */
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
    /**
     * @var string Styles(css) directory
     */
    private $stylesDir;
    /**
     * @var string Scripts(js) directory
     */
    private $scriptsDir;
    /**
     * @var string Images directory
     */
    private $imagesDir;
    /**
     * @var string Resources directory ( if set then styles/scripts/images do not need to be set )
     */
    private $resourcesDir;
    /**
     * @var bool If APC is installed and enabled
     */
    private $hasAPC;
    /**
     * @var string Global conf file path
     */
    private $globalConf;
    /**
     * @var cache Cache object
     */
    private $cache;
    /**
     * @var int Time To Live (ttl) for cache
     */
    private $cachettl = 900; //15m

    /**
     * Initiates the core components
     */
    public function __construct($devMode = false)
    {
        $pathKey = "";
        $hasKeyAPC = false;
        $hasKeyCache = false;
        $this->devMode = $devMode;
        $this->cache = new cache();

        $this->controllerDir[0] = DS . "src" . DS . "Core" . DS . "Controllers" . DS;
        $this->modelDir[0] = DS . "src" . DS . "Core" . DS . "Models" . DS;
        $this->globalConf = $globalConf = DS . "config" . DS . "global.conf.php";

        $apcisloaded = extension_loaded("apc");
        $apcisEnabled = ini_get('apc.enabled');
        $this->hasAPC = $apcisEnabled && $apcisloaded ? true : false;

        $this->request = $req = new request();
        $this->path = $req->getPath();

        $clear = htmlentities(filter_var($_GET['action']), FILTER_SANITIZE_STRING);
        if ($clear === 'clear_cache') {
            $this->clearCache();
        }

        if($this->hasAPC && !$this->devMode) {
            $path = $this->path;
            $pathKey = md5($path . "_view");
            $hasKeyAPC = apc_exists($pathKey);
            $hasKeyCache = $this->cache->cacheExists($pathKey);
        }

        if($hasKeyAPC) {
            $this->APCinit($pathKey);
            $this->cacheMethod = "APC";
        } elseif($hasKeyCache) {
            $this->cachedinit($pathKey);
            $this->cacheMethod = "internal_cache";
        } else {
            $this->defaultinit();
            $this->cacheMethod = 'none';
        }

        spl_autoload_register([$this, 'autoloadController']);
        spl_autoload_register([$this, 'autoloadModel']);

    }

    /**
     * Default initialization when no cache is available
     */
    private function defaultinit()
    {
        $this->route = new routes($this->request);
        $this->view = new view();
        $this->globalConf = require_once _ROOT . $this->globalConf;
    }

    /**
     * Cached execution if Core Framework's cache is available
     *
     * @param $key
     */
    private function cachedinit($key){
        $this->view = $this->cache->getCache($key);
    }

    /**
     * Cached execution if APC's cache is available
     *
     * @param $apcKey
     */
    private function APCinit($apcKey)
    {
        $this->view = apc_fetch($apcKey);
    }

    /**
     * Clear / reset APC Cache
     */
    public function clearCache()
    {
        if($this->hasAPC) {
            apc_clear_cache();
        }
        $this->cache->clearCache();
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
     * Run all Core components to produce output. Throws Exception if class or method is not found
     *
     * @throws \ErrorException
     */
    public function Load()
    {
        if($this->cacheMethod !== 'none') {
            $this->view->render();
        }else{
            $this->loadAll();
        }
    }

    /**
     * Loads all components
     *
     * @throws \ErrorException
     */
    private function loadAll()
    {
        $this->route->findMatch();
        $this->getVars = $this->route->getGetVars();
        $this->postVars = $this->route->getPostVars();
        $this->cookies = $this->route->getCookies();
        $isFEComponent = $this->route->getIsFEComponent();
        $isCustomServe = $this->route->getIsCustomServe();
        $isRootFile = $this->route->getIsRootFile();
        $controller = $this->route->getController();
        $definedMethod = $this->route->getDefinedMethod();
        $reqstMethod = $this->route->getReqstMethod();
        $this->modelName = $this->route->getModel();
        $this->view->setDebugMode($this->devMode);

        if ((empty($controller) && !$isFEComponent && !$isRootFile) || $definedMethod !== $reqstMethod) {
            $this->route->header = '404';
            $this->route->setController('errorController');
            $this->route->setMethod('pageNotFound');
        }

        if ($isRootFile) {
            $r = $this->handleFEComponents(true);
            if ($r === false) {
                $this->route->header = '404';
                $this->route->setController('errorController');
                $this->route->setMethod('pageNotFound');
            } else {
                exit;
            }
        }

        if ($isFEComponent) {
            $r = $this->handleFEComponents();
            if ($r === false) {
                $this->route->header = '404';
                $this->route->setController('errorController');
                $this->route->setMethod('pageNotFound');
            } else {
                exit;
            }
        }

        if ($isCustomServe === true) {
            $this->handleCustomServe();
            exit;
        }

        if ($this->view->disabled === false) {
            $this->render();
        }

    }

    /**
     * function to handle the Front End Components
     * @param bool $isRoot
     * @return bool
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
            $folder = "root" . DS;
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

        if (is_readable($pathTpl)) {
            $this->setHeaders($fileExt);
            include_once $pathTpl;
            return true;

        } else {
            return false;
        }

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
     * Serve Custom content. This is to handle
     * @throws \ErrorException
     */
    private function handleCustomServe()
    {
        $args = $this->route->getArgs();
        $routeVars = $this->route->getGetVars();
        $showHeader = empty($routeVars['showHeader']) ? true : $routeVars['showHeader'];
        $showFooter = empty($routeVars['showFooter']) ? false : $routeVars['showFooter'];
        $fileName = $this->route->getFileName();
        $fileName = !empty($fileName) ? $fileName : 'index';
        $fileExt = $this->route->getFileExt();
        $fileExt = !empty($fileExt) ? $fileExt : 'html';

        $referencePath = $this->route->getReferencePath();

        $rPathArr = explode('/', $referencePath);

        $realPath = _APPDIR . DS;

        foreach ($rPathArr as $part) {
            $realPath .= $part . DS;
        }

        if (!empty($args)) {
            $key = key($args);
            $realPath .= $args[$key];
        } else {
            $realPath .= $fileName . "." . $fileExt;
        }

        if ($showHeader === true && $fileExt === 'html') {

            $this->route->addRouteVars(['customServePath' => $realPath]);
            $this->view->setDebugMode(false);
            $this->render();

        } else {
            $this->setHeaders($fileExt);
            include_once $realPath;
        }

    }

    /**
     * Calls the associated controller and view to render final output
     * @throws \ErrorException
     */
    private function render()
    {
        $controller = $this->route->getController();
        $namespace = $this->route->getNamespace();
        $namespace = empty($namespace) ? 'Core\\Controllers' : $namespace;
        $method = $this->route->getMethod();
        $method = empty($method) ? 'indexAction' : $method;
        $model = $this->modelName;
        $model = !empty($model) ? $model : null;
        $modelDir = $this->modelDir;
        $args = $this->route->getArgs();
        $args = !empty($args) ? $args : null;
        $required = $this->route->getRequired();
        $routeParams = $this->route->getRouteVars();
        $view = $this->view;

        $class = $namespace . "\\" . $controller;


        if (class_exists($class)) {
            $this->controller = new $class(
                $controller,
                $method,
                $routeParams,
                $view,
                $this->postVars,
                $this->getVars,
                $modelDir,
                $model,
                $args,
                $required
            );
            if (method_exists($this->controller, $method) && $args != null) {
                $this->templateInfo = $this->controller->$method($args);
            } else {
                $this->templateInfo = $this->controller->$method();
            }
        } else {
            throw new \ErrorException("Class or Method not found", 11);
        }


        $ttl = $this->cachettl;
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
        if ($this->hasAPC && (!$this->devMode || $this->forceApc)) {
            apc_store($pathKey, $this->view, $ttl);
        }

        $this->cache->cacheContent($pathKey, $this->view, $ttl);

        $this->view->render();

    }

    /**
     * Set the default tpl file. By default this is root.tpl
     * @param $tpl
     */
    public function setDefaultTpl($tpl)
    {
        $this->defaultTpl = $tpl;
    }

    /**
     * Set the cache TTL defaults
     * @param $sec
     */
    public function setCachettl($sec)
    {
        $this->cachettl = $sec;
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
        //$this->route->setTemplateDir($dir);
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

    /**
     * Sleep magic method
     *
     * @return array
     */
    public function __sleep()
    {
        return ['controllerDir', 'modelDir', 'devMode', 'path', 'forceApc', 'templateDir', 'defaultTpl', 'defaultController', 'modelName', 'templateInfo', 'getVars', 'postVars', 'cookies', 'validExtensions', 'styleDir', 'scriptsDir', 'imageDir', 'resourcesDir', 'hasAPC', 'globalConf', 'cachettl'];
    }


    /**
     * Wakeup magic method
     */
    public function __wakeup()
    {
        $this->route = null;
        $this->request = null;
        $this->view = new Views\view();
    }

}
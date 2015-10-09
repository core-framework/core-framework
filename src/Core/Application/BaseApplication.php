<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 06/02/15
 * Time: 4:48 PM
 */

namespace Core\Application;

use Core\Routes\Router;

/**
 * Base Application class
 *
 * Class BaseApplication
 * @package Core\Application
 */
abstract class BaseApplication extends Components
{

    /**
     * Begin state
     *
     * @var int
     */
    const STATUS_BEGIN = 0;

    /**
     * Initiated state
     *
     * @var int
     */
    const STATUS_INIT = 1;

    /**
     * Request handling state
     *
     * @var int
     */
    const STATUS_HANDLING_REQUEST = 2;

    /**
     * Loading from cache state
     *
     * @var int
     */
    const STATUS_LOADING_FROM_CACHE = 3;

    /**
     * Computing response state
     *
     * @var int
     */
    const STATUS_COMPUTING_RESPONSE = 4;

    /**
     * Response sending state
     *
     * @var int
     */
    const STATUS_SENDING_RESPONSE = 5;

    /**
     * Post response state
     *
     * @var int
     */
    const STATUS_SENT_RESPONSE = 6;

    /**
     * End state
     *
     * @var int
     */
    const STATUS_END = 7;

    /**
     * The current environment status prod | dev
     *
     * @var string | 'prod' | 'dev'
     */
    public $_ENV = 'prod';

    /**
     * If application is running in debug mode.
     *
     * @var bool
     */
    public $_DEBUG = false;

    /**
     * Default controller namespace
     *
     * @var string
     */
    public $controllerNamespace = 'Core\\Controllers';

    /**
     * Application Name
     *
     * @var string
     */
    public $applicationName;

    /**
     * Application Version
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * default charset to us Application
     *
     * @var string
     */
    public $charset = 'UTF-8';

    /**
     * Application default language
     *
     * @var string
     */
    public $language = 'en_US';
    /**
     * The parameters of the URI requested
     *
     * @var null | array
     */
    public $routeParams;
    /**
     * @var null | string
     */
    public $action;
    /**
     * @var null | array
     */
    public $args;
    /**
     * Application state/status
     *
     * @var int
     */
    public $status;
    /**
     * Application View
     *
     * @var \Core\Views\AppView
     */
    public $view;
    /**
     * Application wide Time to Live (ttl)
     *
     * @var int
     */
    public $ttl = 3600;
    /**
     * Requested URI
     *
     * @var null | string
     */
    private $requestedURI;

    /**
     * Application constructor
     *
     * @param array $config Application configuration from the config file(s)
     */
    public function __construct($config = [])
    {
        $this->_ENV = defined('CORE_ENV') ? CORE_ENV : 'prod';
        $this->_DEBUG = defined('CORE_DEBUG') ? CORE_DEBUG : false;

        CoreApp::$app = $this;
        $this->status = self::STATUS_BEGIN;
        $this->init($config);
    }

    /**
     * Application initiation
     *
     * @param array $config Application configuration from the config file(s)
     */
    public function init($config = [])
    {
        $this->status = self::STATUS_INIT;

        $this->loadConf($config);
        $this->loadComponents();
    }

    /**
     * Runs the application
     *
     * @throws \ErrorException
     */
    public function run()
    {
        /** @var \Core\CacheSystem\Cache $cache */
        $this->cache = $cache = $this->get('Cache');

        if (isset($_GET['action']) && $_GET['action'] === 'clear_cache') {
            $cache->clearCache();
        }

        $path = $_SERVER['REQUEST_URI'];
        $this->conf['$global']['routeKey'] = $routeKey = md5($path . '_route_' . session_id());
        $this->conf['$global']['viewKey'] = $viewKey = md5($path . '_view_' . session_id());

        if ($cache->cacheExists($viewKey)) {
            $this->status = self::STATUS_LOADING_FROM_CACHE;
            $this->renderFromCache($viewKey);
            return;
        }

        $this->router = $cache->getCache($routeKey);

        if (!($this->router instanceof Router)) {
            $this->router = $this->get('Router');
            $this->requestedURI = $this->router->path;
        }

        $this->parseRoute();

    }

    /**
     * Render Application view from cache
     *
     * @param $key
     * @return bool
     * @throws \ErrorException
     */
    public function renderFromCache($key)
    {
        /** @var \Core\Views\View $view */
        $this->view = $this->cache->getCache($key);
        $this->view->render();
    }

    /**
     * Parses the URI route requested
     *
     * @throws \ErrorException
     */
    public function parseRoute()
    {
        $this->status = self::STATUS_HANDLING_REQUEST;
        $this->routeParams = $routeParams = $this->router->resolve($this->global['useAestheticRouting']);

        if(!isset($routeParams['noCacheRoute']) || $routeParams['noCacheRoute'] === false) {
            $this->cache->cacheContent($this->conf['$global']['routeKey'], $this->router, $this->ttl);
        }

        $this->view = $this->get('View');
        if ($this->router->customServe === true) {
            $this->handleCustomServe($routeParams);
            $this->render();
        } else {
            $this->loadController($routeParams);
            $this->render();
        }

    }

    /**
     * Serve Custom content. This is to handle custom serving of view content
     *
     * @param array $routeParams
     */
    private function handleCustomServe($routeParams = [])
    {
        if (empty($routeParams)) {
            return;
        }

        $args = $routeParams['args'];
        $routeVars = $routeParams['routeVars'];
        $showHeader = isset($routeVars['showHeader']) && $routeVars['showHeader'] === true ? true : false;
        $showFooter = isset($routeVars['showFooter']) && $routeVars['showFooter'] === true ? true : false;
        $serveIframe = isset($routeVars['serveIframe']) && $routeVars['serveIframe'] === true ? true : false;
        $fileName = $this->router->fileName;
        $fileName = !empty($fileName) ? $fileName : 'index';
        $fileExt = $this->router->fileExt;
        $fileExt = !empty($fileExt) ? $fileExt : 'html';

        $referencePath = $this->router->referencePath;

        $rPathArr = explode('/', $referencePath);

        $realPath = $this->appPath . '/';

        foreach ($rPathArr as $part) {
            $realPath .= $part . DS;
        }

        if (!empty($args)) {
            $key = key($args);
            $realPath .= $args[$key];
        } else {
            $realPath .= $fileName . "." . $fileExt;
        }

        if ($showHeader === true && $serveIframe === false && $fileExt === 'html') {
            $this->view->showHeader = $showHeader;
            $this->view->showFooter = $showFooter;
            $this->view->setTemplateVars('customServePath', $realPath);
            $this->view->setDebugMode(false);
            $this->loadController($routeParams);

        } elseif ($serveIframe === true && $showHeader === true) {
            $this->view->showHeader = $showHeader;
            $this->view->showFooter = $showFooter;
            $this->view->setTemplateVars('iframeUrl', $referencePath);
            $this->view->setDebugMode(false);
            $this->loadController($routeParams);

        } else {
            $this->setHeaders($fileExt);
            include_once $realPath;
            $this->view->disable();
        }

    }

    /**
     * Loads the controller from the provided route parameters
     *
     * @param array $routeParams
     */
    public function loadController($routeParams = [])
    {
        $this->status = self::STATUS_COMPUTING_RESPONSE;

        // default status var
        $status = "success";
        // $routeParams empty change set status to "error"
        if (empty($routeParams)) {
            $status = "error";
        }

        // check if defined method is Array
        if (is_array($this->router->definedMethod) && $status !== "error") {
            // If not in array set status to "error"
            if(!in_array($this->router->httpMethod, $this->router->definedMethod)) {
                $status = "error";
            }
        }
        // If defined method and current methods don't match change status to "error"
        elseif ($this->router->httpMethod !== $this->router->definedMethod) {
            $status = "error";
        }

        // status is "error" set error route params
        if ($status === "error") {
            $routeParams['namespace'] = '\\Core\\Controllers';
            $routeParams['controller'] = 'errorController';
            $routeParams['method'] = 'pageNotFound';
        }

        $class = $routeParams['namespace'] . "\\" . $routeParams['controller'];
        $controllerObj = new $class($this->router, $this->view, $this->conf);
        $controllerObj->$routeParams['method'](isset($routeParams['args']) ? $routeParams['args'] : null);

    }

    /**
     * Set header
     * @param null | string $type
     */
    public function setHeaders($type = null)
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

    public function render()
    {
        if ($this->view->disabled !== true) {
            $this->view->render();
            $this->status = self::STATUS_SENT_RESPONSE;

            if ((isset($this->conf['$global']['noCache']) && $this->conf['$global']['noCache'] === true) || (isset($routeParams['noCache']) && $routeParams['noCache']) === true) {
                return;
            }

            $this->cache->cacheContent($this->conf['$global']['viewKey'], $this->view, $this->ttl);
        }
    }

    /**
     * Application End
     */
    public function __destruct()
    {
        $this->status = self::STATUS_END;
    }


}

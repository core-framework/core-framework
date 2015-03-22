<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 06/02/15
 * Time: 4:48 PM
 */

namespace Core\Application;

use Core\Routes\Router;

abstract class BaseApplication extends Components
{

    const STATUS_BEGIN = 0;

    const STATUS_LOADING = 1;

    const STATUS_HANDLING_REQUEST = 2;

    const STATUS_LOADING_FROM_CACHE = 3.1;

    const STATUS_COMPUTING_RESPONSE = 3.2;

    const STATUS_SENDING_RESPONSE = 4;

    const STATUS_END = 5;

    public $_ENV = 'prod';

    public $_DEBUG = false;

    public $controllerNamespace = 'Core\\Controllers';

    public $applicationName;

    public $version = '1.0.0';

    public $charset = 'UTF-8';

    public $language = 'en-US';

    public $requestedURI;

    public $routeParams;

    public $action;

    public $args;

    public $status;

    /**
     * @var \Core\Views\AppView
     */
    public $view;

    public $ttl = 3600;

    public function __construct($config = [])
    {
        $this->_ENV = defined('CORE_ENV') ? CORE_ENV : 'prod';
        $this->_DEBUG = defined('CORE_DEBUG') ? CORE_DEBUG : false;

        CoreApp::$app = $this;
        $this->status = self::STATUS_BEGIN;
        $this->init($config);
    }

    public function init($config)
    {
        $this->status = self::STATUS_LOADING;

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

        $path = $_SERVER['REQUEST_URI'];
        $routeKey = md5($path . '_route');
        $viewKey = md5($path . '_view');

        if ($cache->cacheExists($viewKey)) {
            $this->status = self::STATUS_LOADING_FROM_CACHE;
            $this->loadFromCache($cache, $viewKey);
            return;
        }

        if ($cache->cacheExists($routeKey)) {
            $router = $cache->getCache($routeKey);
            if ($router instanceof Router) {
                $this->status = self::STATUS_HANDLING_REQUEST;
                $this->router = $router;
                $this->parseRoute($this->router);
                return;
            }
        }

        $this->status = self::STATUS_HANDLING_REQUEST;
        $this->router = $this->get('Router');
        $cache->cacheContent($routeKey, $this->router, $this->ttl);
        $this->requestedURI = $this->router->path;
        $this->parseRoute($this->router);

    }

    /**
     * @param \Core\CacheSystem\Cache $cache
     * @param $key
     */
    public function loadFromCache($cache, $key)
    {
        /**
         * @var \Core\Views\View $view
         */
        $view = $cache->getCache($key);
        $view->render();
    }

    public function parseRoute()
    {
        $this->status = self::STATUS_COMPUTING_RESPONSE;
        if (!is_object($this->router)) {
            var_dump($this);
            exit;
        }
        $this->routeParams = $routeParams = $this->router->resolve();
        $this->view = $this->get('View');
        if ($this->router->customServe === true) {
            $this->handleCustomServe($routeParams);
        } else {
            $this->loadController($routeParams);
            if ($this->view->disabled !== true) {
                $this->view->render();
            }
        }

    }

    /**
     * Serve Custom content. This is to handle
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

        if ($showHeader === true && $serveIframe === false && $fileExt === 'html') {
            $this->view->showHeader = $showHeader;
            $this->view->showFooter = $showFooter;
            //$this->router->addRouteVars(['customServePath' => $realPath]);
            $this->view->tplEngine->assign('customServePath', $realPath);
            $this->view->setDebugMode(false);
            $this->loadController($routeVars);

        } elseif ($serveIframe === true && $showHeader === true) {
            $this->view->showHeader = $showHeader;
            $this->view->showFooter = $showFooter;
            $this->view->setTemplateVars('iframeUrl', $referencePath);
            $this->view->setDebugMode(false);
            $this->loadController($routeVars);

        } else {
            $this->setHeaders($fileExt);
            include_once $realPath;
            $this->view->disable();
        }

    }

    public function loadController($routeParams = [])
    {
        if (empty($routeParams)) {
            $routeParams['namespace'] = '\\Core\\Controllers';
            $routeParams['controller'] = 'errorController';
            $routeParams['method'] = 'pageNotFound';
        }

        $class = $routeParams['namespace'] . "\\" . $routeParams['controller'];
        $controllerObj = new $class($this->router, $this->view, $this->conf);
        $controllerObj->$routeParams['method'](isset($routeParams['args']) ? $routeParams['args'] : '');

    }

    /**
     * Set header
     * @param null $type
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

    public function __destruct()
    {
//        if ($this->_DEBUG) {
//            $html = include($this->basePath . '/src/Core/Views/debug.php');
//            echo $html;
//        }
    }


}
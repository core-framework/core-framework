<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 07/03/15
 * Time: 2:17 AM
 */

namespace Core\Controllers;


use Core\Application\Application;
use Core\Application\CoreApp;
use Core\Routes\Router;
use Core\Views\AppView;

class BaseController
{

    /**
     * @var Router
     */
    public $router;

    /**
     * @var AppView
     */
    public $view;

    /**
     * @var Array
     */
    public $conf;

    public $POST;

    public $GET;

    public $method;

    public $csrf;

    function __construct(Router $router, AppView $view, $conf = [])
    {
        $this->router = $router;
        $this->view = $view;
        $this->conf = $conf;

        $this->POST = &$router->POST;
        $this->GET = &$router->GET;
        $this->method = &$router->method;

        $this->baseInit();
    }


    public function baseInit()
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

        if (isset($this->conf['routeVars']['pageName'])) {
            $this->view->setTemplateVars('pageName', $this->conf['routeVars']['pageName']);
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
                $metas = $metaContent["/" . $this->router->path];
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

            $this->view->setTemplateVars('metas', $metas);
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
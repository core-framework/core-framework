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
use Core\DI\DI;
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

    public $postVars;

    public $method;

    public $csrf;

    function __construct(Router $router, AppView $view, $conf = [])
    {
        $this->router = $router;
        $this->view = $view;
        $this->conf = $conf;

        $this->postVars = &$router->postVars;
        $this->getVars = &$router->getVars;
        $this->method = &$router->method;

        $this->checkForInput();
        $this->baseInit();
    }

    /**
     * check for input (support for angular POST)
     *
     */
    private function checkForInput()
    {
        $postdata = file_get_contents("php://input");
        if (!empty($postdata) && is_array($postdata)) {
            $postdata = $this->inputSanitize($postdata);
            $this->postVars['json'] = json_decode($postdata);
        } elseif (!empty($postdata) && is_string($postdata)) {
            if ($this->method === 'put') {
                parse_str($postdata, $this->postVars['put']);
                $this->postVars['put'] = $this->inputSanitize($this->postVars['put']);
            }
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
        //str_replace($this->illegal, '', $sanitizedData);

        return $sanitizedData;
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


    public function resetCache($key = null)
    {
        $routes = $this->conf['$routes'];
        /** @var \Core\CacheSystem\BaseCache $cache */
        $cache = Application::get('Cache');

        if (!empty ($key)) {
            $cache->deleteCache($key);
        }

        foreach($routes as $route => $params) {
            $key = $route . '_view_' . session_id();
            $cache->deleteCache($key);
        }

    }

}
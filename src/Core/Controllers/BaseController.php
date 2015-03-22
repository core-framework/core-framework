<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 07/03/15
 * Time: 2:17 AM
 */

namespace Core\Controllers;


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

    private $csrf;

    function __construct(Router $router, AppView $view, $conf = [])
    {
        $this->router = $router;
        $this->view = $view;
        $this->conf = $conf;

        $this->checkForInput();
        $this->baseInit();
    }

    /**
     * check for input (support for angular POST)
     *
     */
    private function checkForInput()
    {
        $postData = file_get_contents("php://input");
        if ($postData) {
            $postData = $this->inputSanitize($postData);
            $this->router->postVars['json'] = json_decode($postData);
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
        $this->view->tplEngine->assign('title', $pageTitle);

        if (isset($this->conf['routeVars']['pageName'])) {
            $this->view->tplEngine->assign('pageName', $this->conf['routeVars']['pageName']);
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
                $this->view->tplEngine->assign('title', $metas['pageTitle']);
                unset($metas['pageTitle']);
            }

            $this->view->tplEngine->assign('metas', $metas);
            $this->view->tplEngine->assign('csrf', $this->csrf);
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

}
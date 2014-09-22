<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 21/08/14
 * Time: 8:41 PM
 */

namespace Core\Controllers;

use Core\Models;
use Core\Views\view;

class controller
{
    public $view;
    public $response;
    public $err404Tpl = "errors/404.tpl";
    private $controller;
    private $method;
    private $args;
    private $modelName;
    private $model;
    private $pageParams;
    private $req;
    private $getVars;
    private $postVars;
    private $modelDir;
    private $defaultTpl = 'homepage/home.tpl';
    private $illegal = [
        '$',
        '*',
        '\'',
        '<',
        '>',
        '^',
        '(',
        ')',
        '[',
        ']',
        '\\',
        '/',
        '!',
        '~',
        '`',
        '{',
        '}',
        '|',
        '?php',
        'script'
    ];

    /**
     * instantiates Controller object from route vars
     *
     * @param string $controller
     * @param string $method
     * @param array $pageParams
     * @param view $view
     * @param array $getVars
     * @param array $postVars
     * @param string $modelDir
     * @param null || string $modelName
     * @param null || array $args
     * @param null || array $req
     */
    public function __construct(
        $controller,
        $method,
        $pageParams,
        view $view,
        $postVars,
        $getVars,
        $modelDir,
        $modelName = null,
        $args = null,
        $req = null
    ) {

        $this->controller = $controller;
        $this->$method = $method;
        $this->args = $args;
        $this->pageParams = $pageParams;
        $this->view = $view;
        $this->getVars = $getVars;
        $this->postVars = $postVars;
        $this->checkForInput();
        $this->initResponse();
        if (!empty($modelName)) {
            $this->modelName = $modelName;
            //$this->__autoLoad($modelName);
            //$modelStr = "\\Models\\" . $modelName;
            $this->model = new $modelName();

        }
        if (!empty($req)) {
            $this->req = $req;
        }

    }

    /**
     * check for input (support for angular POST)
     */
    private function checkForInput()
    {
        $postdata = file_get_contents("php://input");
        if ($postdata) {
            $postdata = $this->inputSanitize($postdata);
            $this->postVars['json'] = json_decode($postdata);
        }
    }

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
        str_replace($this->illegal, '', $sanitizedData);

        return $sanitizedData;
    }

    /**
     * Init view response
     */
    private function initResponse()
    {
        $params = $this->pageParams;
        $this->generateCSRFKey();
        $this->response['vars']['title'] = $params['pageTitle'];
        $this->response['vars']['pageName'] = $params['pageName'];
        $this->response['vars']['csrf'] = $_SESSION['csrf'];
    }

    /**
     * Generate CSRF key
     */
    private function generateCSRFKey()
    {
        $key = sha1(microtime());
        $_SESSION['csrf'] = empty($_SESSION['csrf']) ? $key : $_SESSION['csrf'];
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        $this->response['tpl'] = 'homepage/home.tpl';
        return $this->responseSend();
    }

    /**
     * @return mixed
     */
    public function responseSend()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return null if null or mixed
     */
    public function getModelName()
    {
        return $this->modelName;
    }

    /**
     * @return object model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return null if null or mixed
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * @return null if null or mixed
     */
    public function getReq()
    {
        return $this->req;
    }

    public function getGetVars()
    {
        return $this->getVars;
    }

    public function getPostVars()
    {
        return $this->postVars;
    }

    /**
     * loads required files
     */
    public function loadReq()
    {
        $req = $this->req;
        if (sizeof($req['php']) != 0) {
            foreach ($req['php'] as $filepath) {
                $this->__fileLoad(_ROOT . $filepath);
            }
        }
    }

    /**
     * @param $file
     * @return bool
     */
    private function __fileLoad($file)
    {
        if (file_exists($file)) {
            require_once $file;
        } else {
            return false;
        }
    }

    /**
     * @param $model
     * @return bool false if file does not exist;
     */
    private function __autoload($model)
    {
        $file = _ROOT . DS . "Core " . DS . "Models" . DS . $model . ".php";

        $elsefile = _ROOT . $this->modelDir . $model . ".php";

        $loaded = $this->__fileLoad($file);
        if (!$loaded) {
            return false;
        }
    }

    /**
     * loads required methods of loaded files
     */
    private function loadReqMethod()
    {
        $req = $this->req;
        if (sizeof($req['autoLoad']) != 0) {
            $method = $req['autoLoad']['method'];
            if (sizeof($req['autoLoad']['args']) != 0) {

                $args = "";
                foreach ($req['autoLoad']['args'] as $key => $val) {

                    if ($key === key($req['autoLoad']['args'])) {
                        $args .= $val;
                    } else {
                        $args .= $val . ",";
                    }
                }

                $method($args);

            } else {
                $method();
            }
        }
    }

}
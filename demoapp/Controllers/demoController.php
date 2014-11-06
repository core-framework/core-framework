<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace demoapp\Controllers;

use Core\Controllers\controller;

/**
 * @author Shalom Sam <shalom.s@coreframework.in>
 * Class demoController
 * @package demoapp\Controllers
 */
class demoController extends controller
{

    public function indexAction()
    {
        return $this->commonFunction('home');
    }

    public function commonFunction($pageName)
    {
        $lang = $this->config->current_lang;
        if (empty($lang)) {
            $lang = 'en_us';
        }

        $commonLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . "common.php";
        $pageLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . $pageName . ".php";
        $pageTpl = "demopages/" . $pageName . ".tpl";


        $this->response['tpl'] = 'demopages/demo.tpl';
        $this->response['vars']['includeTpl'] = $pageTpl;
        $this->response['vars']['pageName'] = $pageName;
        $this->response['vars']['docVarsCom'] = include_once $commonLangFile;

        if (is_readable($pageLangFile)) {
            $this->response['vars'][$pageName] = include_once $pageLangFile;
        } else {
            $this->response['vars']['error'] = "Page not found";
        }

        return $this->getResponse();
    }

    public function aboutAction()
    {
        return $this->commonFunction('about');
    }

    public function getstartedAction()
    {
        return $this->commonFunction('get_started');
    }

    public function customServeAction()
    {
        $lang = $this->config->current_lang;
        if (empty($lang)) {
            $lang = 'en_us';
        }
        $this->response['tpl'] = 'demopages/demo.tpl';
        $commonLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . "common.php";
        $this->response['vars']['docVarsCom'] = include_once $commonLangFile;

        return $this->getResponse();
    }

    public function apiAction()
    {
        $routeParams = $this->getRouteParams();
        $lang = $this->config->current_lang;
        if (empty($lang)) {
            $lang = 'en_us';
        }

        $commonLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . "common.php";

        $this->response['tpl'] = 'demopages/demo.tpl';
        $this->response['vars']['docVarsCom'] = include_once $commonLangFile;
        $this->response['vars']['customServePath'] = $routeParams['customServePath'];
        $this->response['vars']['mainPage'] = 'documentation';
        $this->response['vars']['subPage'] = true;

        return $this->getResponse();

    }
} 
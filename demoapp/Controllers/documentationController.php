<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 24/10/14
 * Time: 1:24 AM
 */

namespace demoapp\Controllers;


class documentationController extends demoController {

    public function indexAction(){
        return $this->commonFunction('documentation');
    }

    public function documentationAction($payload){

        $pageName = $payload['page'];
        $lang = $this->config->current_lang;
        if(empty($lang)){
            $lang = 'en_us';
        }

        $commonLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . "common.php";
        $pageLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . "documentations" . DS . $pageName . ".php";
        $pageTpl = "demopages/documentations/sub_pages.tpl";

        $this->response['tpl'] = 'demopages/demo.tpl';
        $this->response['vars']['includeTpl'] = $pageTpl;
        $this->response['vars']['mainPage'] = 'documentation';
        $this->response['vars']['subPage'] = true;
        $this->response['vars']['pageName'] = $pageName;
        $this->response['vars']['docVarsCom'] = include_once $commonLangFile;

        if (is_readable($pageLangFile)) {
            $this->response['vars']['documentation'] = include_once $pageLangFile;
        } else {
            $this->response['vars']['error'] = "Page not found";
        }

        return $this->getResponse();

    }

    public function apiAction(){
        include _ROOT . DS . "demoapp" . DS . "Templates" . DS . "api" . DS . "index.html";
        exit;
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 22/10/14
 * Time: 10:22 AM
 */

namespace demoapp\Controllers;


class tutorialController extends demoController {

    public function indexAction(){
        return $this->commonFunction('tutorial');
    }

    public function tutorialAction($pageName){

        $lang = $this->config->current_lang;
        if(empty($lang)){
            $lang = 'en_us';
        }

        $commonLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . "common.php";
        $pageLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . $pageName . ".php";
        $pageTpl = "demopages/tutorials/tutorials.tpl";

        $this->response['tpl'] = 'demopages/demo.tpl';
        $this->response['vars']['includeTpl'] = $pageTpl;
        //$this->response['vars']['pageKey'] = 'tutorial';
        $this->response['vars']['pageName'] = $pageName;
        $this->response['vars']['docVarsCom'] = include_once $commonLangFile;

        if (is_readable($pageLangFile)) {
            $this->response['vars']['tutorials'] = include_once $pageLangFile;
        } else {
            $this->response['vars']['error'] = "Page not found";
        }

        return $this->getResponse();

    }

} 
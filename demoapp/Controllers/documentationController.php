<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 24/10/14
 * Time: 1:24 AM
 */

namespace demoapp\Controllers;


class documentationController extends demoController
{

    public function indexAction()
    {
        $this->commonFunction('documentation');
    }

    public function documentationAction($payload)
    {

        $pageName = $payload['page'];
        $lang = $this->config->current_lang;
        if (empty($lang)) {
            $lang = 'en_us';
        }

        $commonLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . "common.php";
        $pageLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . "documentations" . DS . $pageName . ".php";
        $pageTpl = "demopages/documentations/sub_pages.tpl";

        $this->view->setTemplate('demopages/demo.tpl');
        $this->view->setTemplateVars('includeTpl', $pageTpl);
        $this->view->setTemplateVars('mainPage', 'documentation');
        $this->view->setTemplateVars('subPage', true);
        $this->view->setTemplateVars('pageName', $pageName);
        $this->view->setTemplateVars('docVarsCom', include_once $commonLangFile);

        if (is_readable($pageLangFile)) {
            $this->view->setTemplateVars('documentation', include_once $pageLangFile);
        } else {
            $this->response['vars']['error'] = "Page not found";
            $this->view->setTemplateVars('error', "Page not found");
        }

    }

    public function apiAction()
    {
        include _ROOT . DS . "demoapp" . DS . "Templates" . DS . "api" . DS . "index.html";
        exit;
    }

} 
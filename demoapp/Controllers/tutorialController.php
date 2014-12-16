<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 22/10/14
 * Time: 10:22 AM
 */

namespace demoapp\Controllers;


class tutorialController extends demoController
{

    public function indexAction()
    {
        $this->commonFunction('tutorial');
    }

    public function tutorialAction($pageName)
    {

        $lang = $this->config->current_lang;
        if (empty($lang)) {
            $lang = 'en_us';
        }

        $commonLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . "common.php";
        $pageLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . $pageName . ".php";
        $pageTpl = "demopages/tutorials/tutorials.tpl";

        $this->view->setTemplate('demopages/demo.tpl');
        $this->view->setTemplateVars('includeTpl', $pageTpl);
        $this->view->setTemplateVars('pageName', $pageName);
        $this->view->setTemplateVars('docVarsCom', include_once $commonLangFile);

        if (is_readable($pageLangFile)) {
            $this->view->setTemplateVars('tutorials', include_once $pageLangFile);
        } else {
            $this->view->setTemplateVars('error', "Page not found");
        }
    }

} 
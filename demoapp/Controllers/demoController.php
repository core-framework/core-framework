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

use Core\Controllers\Controller;

/**
 * @author Shalom Sam <shalom.s@coreframework.in>
 * Class demoController
 * @package demoapp\Controllers
 */
class demoController extends Controller
{

    public function indexAction()
    {
        $serverName = $this->getServer()['HTTP_HOST'];
        if (preg_match('/^(www\.|dev\.)?coreframework\.in$/', $serverName)) {
            $this->view->setTemplateVars('showProd', true);
        } else {
            $this->view->setTemplateVars('showProd', false);
        }
        $this->commonFunction('home');
    }

    public function commonFunction($pageName)
    {
        $lang = $this->config->current_language;
        if (empty($lang)) {
            $lang = 'en_us';
        }

        $commonLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . "common.php";
        $pageLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . $pageName . ".php";
        $pageTpl = "demopages/" . $pageName . ".tpl";

        $googleVerification = '';
        if ($this->config->__get('google-site-verification')) {
            $googleVerification = $this->config->__get('google-site-verification');
        } elseif(getenv('google-site-verification')) {
            $googleVerification = getenv('google-site-verification');
        } else {
            $googleVerification = "";
        }

        $this->view->setTemplateVars('metas.google-site-verification', $googleVerification);
        $this->view->setTemplate('demopages/demo.tpl');
        $this->view->setTemplateVars('includeTpl', $pageTpl);
        $this->view->setTemplateVars('pageName', $pageName);
        $this->view->setTemplateVars('docVarsCom', include_once $commonLangFile);

        if (is_readable($pageLangFile)) {
            $this->view->setTemplateVars($pageName, include_once $pageLangFile);
        } else {
            $this->view->setTemplateVars('error', "Page not found");
        }
    }

    public function aboutAction()
    {
        $license = _ROOT . DS . "LICENSE";
        $licenseTxt = file_get_contents($license);
        $licenseTxt = preg_replace('/\n/', '<br/>', $licenseTxt);
        $this->view->setTemplateVars('licensetxt', $licenseTxt);
        $this->commonFunction('about');
    }

    public function getstartedAction()
    {
        $this->commonFunction('get_started');
    }

    public function downloadAction()
    {
        $this->commonFunction('download');
    }

    public function customServeAction()
    {
        $lang = $this->config->current_language;
        if (empty($lang)) {
            $lang = 'en_us';
        }
        $this->view->setTemplate('demopages/demo.tpl');
        $commonLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . "common.php";
        $this->view->setTemplateVars('docVarsCom', include_once $commonLangFile);
    }

    public function apiAction()
    {
        $routeParams = $this->getRouteParams();
        $lang = $this->config->current_lang;
        if (empty($lang)) {
            $lang = 'en_us';
        }

        $commonLangFile = _ROOT . DS . "demoapp" . DS . "Templates" . DS . "demopages" . DS . "lang" . DS . $lang . DS . "common.php";

        $this->view->setTemplate('demopages/demo.tpl');
        $this->view->setTemplateVars('docVarsCom', include_once $commonLangFile);
        $this->view->setTemplateVars('customServePath', $routeParams['customServePath']);
        $this->view->setTemplateVars('mainPage', 'documentation');
        $this->view->setTemplateVars('subPage', true);
    }
} 

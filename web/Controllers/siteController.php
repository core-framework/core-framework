<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 07/03/15
 * Time: 1:45 PM
 */

namespace web\Controllers;

use Core\Application\CoreApp;
use Core\Controllers\BaseController;

class siteController extends BaseController
{

    public $appName = 'CoreFramework';
    public $appVersion = 'v3';
    public $language;

    public function indexAction()
    {
        $this->commonFunction('home');
    }

    public function setSiteParams()
    {
        $this->view->setTemplateVars('site.appName', $this->appName);
        $this->view->setTemplateVars('site.appVersion', $this->appVersion);
        $this->view->setTemplateVars('site.language', $this->language);
    }

    public function commonFunction($pageName)
    {
        $this->language = $lang = strtolower(CoreApp::$app->language);
        if (empty($lang)) {
            $lang = 'en_us';
        }

        $this->setSiteParams();
        $commonLangFile = $this->basePath . "/web/Templates/lang/" . $lang . "/common.php";
        $pageLangFile = $this->basePath . "/web/Templates/lang/" . $lang . '/' . $pageName . ".php";
        $pageTpl = 'layouts/' . $pageName . ".tpl";

        $googleVerification = '';
        if ($this->conf['$global']['google-site-verification']) {
            $googleVerification = $this->conf['$global']['google-site-verification'];
        } elseif(getenv('google-site-verification')) {
            $googleVerification = getenv('google-site-verification');
        } else {
            $googleVerification = "";
        }


        $this->view->setTemplateVars('metas.google-site-verification', $googleVerification);
        $this->view->setTemplate('demo.tpl');

        if (!$this->view->tplEngine->templateExists($pageTpl)) {
            $pageTpl = "errors/404.tpl";
            $this->view->setHeader('404');
        }

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
        $license = $this->basePath . "/LICENSE";
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

    public function documentationAction($payload)
    {
        $pageName = $payload['page'];
        $this->language = $lang = strtolower(CoreApp::$app->language);
        if (empty($lang)) {
            $lang = 'en_us';
        }

        $commonLangFile = $this->basePath . "/web/Templates/lang/" . $lang . "/common.php";
        $pageLangFile = $this->basePath . "/web/Templates/lang/" . $lang . "/documentations/" . $pageName . ".php";
        $pageTpl = "layouts/sub_pages.tpl";

        $googleVerification = '';
        if ($this->conf['$global']['google-site-verification']) {
            $googleVerification = $this->conf['$global']['google-site-verification'];
        } elseif(getenv('google-site-verification')) {
            $googleVerification = getenv('google-site-verification');
        } else {
            $googleVerification = "";
        }


        $this->setSiteParams();
        $this->view->setTemplateVars('metas.google-site-verification', $googleVerification);
        $this->view->setTemplate('demo.tpl');
        $this->view->setTemplateVars('includeTpl', $pageTpl);
        $this->view->setTemplateVars('mainPage', 'documentation');
        $this->view->setTemplateVars('subPage', true);
        $this->view->setTemplateVars('pageName', $pageName);
        $this->view->setTemplateVars('docVarsCom', include_once $commonLangFile);

        if (is_readable($pageLangFile)) {
            $this->view->setTemplateVars('documentation', include_once $pageLangFile);
        } else {
            //$this->response['vars']['error'] = "Page not found";
            $this->view->setTemplateVars('error', "Page not found");
        }

    }

    public function customServeAction()
    {
        $lang = $this->conf['$global']['language'];
        if (empty($lang)) {
            $lang = 'en_us';
        }
        $this->view->setTemplate('demo.tpl');
        $commonLangFile = $this->basePath . "web/Templates/lang/" . $lang . "/common.php";
        $this->view->setTemplateVars('docVarsCom', include_once $commonLangFile);
    }


    public function apiAction($payload)
    {
        $this->setSiteParams();
        //$routeParams = $this->router->routeVars;
        $this->language = $lang = strtolower(CoreApp::$app->language);

        if (empty($lang)) {
            $lang = 'en_us';
        }

        $commonLangFile = $this->basePath . "/web/Templates/lang/" . $lang . "/common.php";
        if (is_readable($commonLangFile)) {
            $this->view->setTemplateVars('docVarsCom', include_once $commonLangFile);
        }

        $this->view->setTemplate('demo.tpl');
        $this->view->setTemplateVars('pageName', 'documentation');
        $this->view->setTemplateVars('mainPage', 'documentation');
        $this->view->setTemplateVars('subPage', true);
    }
}
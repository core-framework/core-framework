<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 07/03/15
 * Time: 1:45 PM
 */

namespace web\Controllers;

use Core\Controllers\BaseController;

class siteController extends BaseController
{

    public $appName = 'YourApp';

    public $appVersion = 'v1';

    public function indexAction()
    {
        $this->init();
        $this->view->setTemplate('home.tpl');
    }

    public function init()
    {
        if (isset($this->conf['$global']['google-site-verification'])) {
            $googleVerification = $this->conf['global']['google-site-verification'];
        } elseif (getenv('google-site-verification')) {
            $googleVerification = getenv('google-site-verification');
        } else {
            $googleVerification = "";
        }

        $this->view->setTemplateVars('metas.google-site-verification', $googleVerification);
        $this->view->setTemplateVars('site.appName', $this->appName);
        $this->view->setTemplateVars('site.appVersion', $this->appVersion);

        if (isset($_SESSION['user'])) {
            $this->view->setTemplateVars('site.user', (array)$_SESSION['user']);
        }
    }

    public function aboutAction()
    {
        $this->init();
        $this->view->setTemplate('about.tpl');
    }


}
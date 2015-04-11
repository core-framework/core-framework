<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 07/03/15
 * Time: 1:45 PM
 */

namespace web\Controllers;

use Core\Controllers\BaseController;
use web\Models\User;

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

    public function registerAction()
    {
        $this->view->disable();
        $postVars = $this->post;

        try {

            if ( empty($postVars['lname']) || empty($postVars['fname']) || empty($postVars['email']) || empty($postVars['password']) || empty($postVars['password_confirm']) || empty($postVars['csrf']) ) {
                throw new \ErrorException('One or more user data not provided.');
            }

            if ( $postVars['csrf'] !== $_SESSION['csrf'] ) {
                throw new \ErrorException('CSRF miss match: the CSRF key has expired please reload the page and try again');
            }

            if ( $postVars['password'] !== $postVars['password_confirm'] ) {
                throw new \ErrorException('Password and Confirm password do not match');
            }

            $postVars['name'] = $postVars['fname'] . " " . $postVars['lname'];
            $user = new User($postVars);

            $r = $user->save();
            $jsonArr = [];
            if ($r === true) {
                $this->resetCache();
                $_SESSION['user'] = (array) $user;
                $jsonArr['status'] = 'success';
                $jsonArr['redirectUrl'] = '/';
            } else {
                $r['status'] = 'error';
                $jsonArr['message'] = 'Unable to write to database';
            }

        } catch (\Exception $e) {
            $jsonArr['status'] = 'error';
            $jsonArr['message'] = $e->getMessage();
            $jsonArr['code'] = $e->getCode();
        }

        $json = json_encode($this->utf8ize($jsonArr), JSON_FORCE_OBJECT);
        header('Content-Type: application/json');
        echo $json;

    }

    public function loginAction()
    {
        $this->view->disable();
        $postVars = $this->post;
        try {

            if ( empty($postVars['email']) || empty($postVars['password']) || empty($postVars['csrf']) ) {
                throw new \ErrorException('One or more user data not provided.');
            }

            if ( $postVars['csrf'] !== $_SESSION['csrf'] ) {
                throw new \ErrorException('CSRF miss match: the CSRF key has expired please reload the page and try again');
            }

            $proposedUser = new User();
            $proposedUserObj = $proposedUser->getOneRow(['email' => $postVars['email']]);
            $proposedUserArr = (array) $proposedUserObj;

            if (!$proposedUserObj instanceof User) {
                throw new \LogicException("Invalid User email or password");
            }

            $authenticated = User::check_hash($postVars['password'], $proposedUserObj->pass_hash);

            if ($authenticated === true) {
                $this->resetCache();
                $_SESSION['user'] = $proposedUserArr;
                $json = ['status' => 'success', 'redirectUrl' => '/'];

            } else {
                $json = [ 'status' => 'error', 'message' => 'Invalid User email or password' ];
            }

        } catch (\Exception $e) {
            $json = [ 'status' => 'error', 'message' => $e->getMessage() ];
        }

        echo json_encode($json);
    }

    public function logoutAction()
    {
        $this->view->disable();
        $_SESSION = [];
        session_unset();
        $this->resetCache();
        session_regenerate_id();
        session_destroy();
        header('Location: /');

        exit();
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 07/03/15
 * Time: 1:45 PM
 */

namespace app\Controllers;

use Core\Contracts\View;
use Core\Controllers\BaseController;
use app\Models\User;
use Core\Facades\Cache;
use Core\Facades\Password;
use Core\Facades\Session;
use Core\Response\Response;

class siteController extends BaseController
{
    public $appName = 'YourApp';
    /**
     * @var View $view
     */
    protected $view;
    public $appVersion = 'v1';

    public function indexAction()
    {
        $this->init();
        $this->view->setTemplate('home.tpl');
        $response = new Response($this->view);
        return $response;
    }

    public function init()
    {
        $this->view = $this->application->getView();
        $googleVerification = $this->application->getConfig()->get('metas.google-site-verification', "");
        $this->view->set('metas.google-site-verification', $googleVerification);
        $this->view->set('site.appName', $this->appName);
        $this->view->set('site.appVersion', $this->appVersion);

        //if (isset($_SESSION['user'])) {
        if (Session::has('user')) {
            $this->view->set('site.user', (array) Session::get('user'));
        }
    }

    public function aboutAction()
    {
        $this->init();
        $this->view->setTemplate('about.tpl');
        $response = new Response($this->view);
        return $response;
    }

    public function registerAction()
    {
        $postVars = $this->application->getRequest()->POST();

        try {

            if ( empty($postVars['lname']) || empty($postVars['fname']) || empty($postVars['email']) || empty($postVars['password']) || empty($postVars['password_confirm']) ) {
                throw new \ErrorException('One or more user data not provided.');
            }


            if ( $postVars['password'] !== $postVars['password_confirm'] ) {
                throw new \ErrorException('Password and Confirm password do not match');
            }

            $postVars['name'] = $postVars['fname'] . " " . $postVars['lname'];
            $user = new User($postVars->get());

            $r = $user->save();
            $jsonArr = [];
            if ($r === true) {
                Session::set('user', (array) $user);
                $this->application->getView()->clearCache('home.tpl');
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

        //$json = json_encode($this->utf8ize($jsonArr), JSON_FORCE_OBJECT);
        $response = new Response($jsonArr);
        $response->setCacheControl('nocache');
        return $response;
    }

    public function loginAction()
    {
        $postVars = $this->POST;
        try {

            if ( empty($postVars['email']) || empty($postVars['password']) ) {
                throw new \ErrorException('One or more user data not provided.');
            }

            $user = User::findOne(['email' => $postVars['email']]);

            if (!$user instanceof User) {
                throw new \LogicException("Given User with email - {$postVars['email']} does not exist");
            }

            $authenticated = User::authenticate($user, $postVars['password']);

            if ($authenticated === true) {

                Session::set('user', (array) $user);
                $json = ['status' => 'success', 'redirectUrl' => '/'];

            } else {
                $json = [ 'status' => 'error', 'message' => 'Invalid User email or password' ];
            }

        } catch (\Exception $e) {
            $json = [ 'status' => 'error', 'message' => $e->getMessage() ];
        }

        //echo json_encode($json);
        $response = new Response($json);

        return $response;
    }

    public function logoutAction()
    {
        $this->application->getView()->clearCache();
        Session::destroy();
        setcookie(session_name(), '', time()-42000, '/');
        $response = new Response();
        $response->setCacheControl('nocache');
        $response->redirect('/');
    }

}
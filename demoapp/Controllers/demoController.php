<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 24/08/14
 * Time: 12:13 AM
 */

namespace demoapp\Controllers;

use Core\Controllers\controller;

class demoController extends controller
{

    public function indexAction($payload = null)
    {
        $this->response['tpl'] = 'demopages/demo.tpl';
        if ($payload !== null && !empty($payload['pagename'])) {
            $pagename = $payload['pagename'];
        } else {
            $pagename = 'home';
        }

        $this->response['vars']['pagename'] = $pagename;
        $this->response['vars']['docVarsCom'] = include_once _ROOT . "/demoapp/Templates/demopages/rawfiles/common.php";

        $pageFile = _ROOT . "/demoapp/Templates/demopages/rawfiles/" . $pagename . ".php";
        if (is_readable($pageFile)) {
            $this->response['vars'][$pagename] = include_once _ROOT . "/demoapp/Templates/demopages/rawfiles/" . $pagename . ".php";
        } else {
            $this->response['vars']['error'] = "Page Data not found";
        }


        return $this->responseSend();
    }

} 
<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 18/09/14
 * Time: 10:59 AM
 */

namespace Core\Controllers;

class testController extends controller
{
    public function indexAction()
    {

    }

    public function helloAction($payload)
    {
        $this->response['tpl'] = "simple.tpl";
        $this->response['vars']['name'] = $payload['name'];
        return $this->responseSend();
    }

} 
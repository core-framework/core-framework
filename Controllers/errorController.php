<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 25/08/14
 * Time: 11:10 AM
 */

namespace Controllers;


use Core\Controllers\controller;

class errorController extends controller {

    public function indexAction(){
        $this->response['header'] = '404';
        $this->response['tpl'] = 'errors/404.tpl';
        $this->response['vars']['pageName'] = "PageNotFound";
        $this->response['vars']['title'] = "Page Not Found";
        return $this->responseSend();
        //return ['header' => '404','tpl' => 'errors/404.tpl', 'vars' => []];
    }

    public function pageNotFound(){
        return $this->indexAction();
    }

}
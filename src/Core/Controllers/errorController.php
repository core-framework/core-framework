<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Controllers;


use Core\Controllers\controller;

/**
 * @author Shalom Sam <shalom.s@coreframework.in>
 * Class errorController
 * @package Controllers
 */
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
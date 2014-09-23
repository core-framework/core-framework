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

use Core\Controllers\controller;

/**
 * @author Shalom Sam <shalom.s@coreframework.in>
 * Class demoController
 * @package demoapp\Controllers
 */
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
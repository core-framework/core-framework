<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Controllers;

/**
 * @author Shalom Sam <shalom.s@coreframework.in>
 * Class testController
 * @package Core\Controllers
 */
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
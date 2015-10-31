<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Controllers;

use SebastianBergmann\RecursionContext\Exception;

/**
 * Controller class to handle (html header) errors
 *
 * @package Core\Controllers
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class errorController extends BaseController
{
    /**
     * Method for 404 page not found error
     *
     * @return array|mixed
     */
    public function pageNotFound()
    {
        return $this->indexAction();
    }

    /**
     * Default method for this class
     *
     * @return array|mixed
     */
    public function indexAction()
    {
        if (!$this->router->isAjax) {
            $this->view->setHeader('404');
            $this->view->setTemplate('errors/404.tpl');
            $this->view->setTemplateVars('pageName', "PageNotFound");
            $this->view->setTemplateVars('title', "Page Not Found");
        } else {
            $this->setHeader('404');
            $jsonArr['code'] = '404';
            $jsonArr['message'] = "Page not found";
            $this->sendJson($jsonArr);
        }

    }

    public function errorException($payload)
    {
        if (strtoupper($this->router->httpMethod) === "GET") {
            $this->view->setHeader('404');
            $this->view->setTemplate('errors/404.tpl');
            $this->view->setTemplateVars('pageName', "PageNotFound");
            $this->view->setTemplateVars('info', $payload['message']);
            $this->view->setTemplateVars('title', "Page Not Found");
        } else {
            $this->setHeader('404');
            $jsonArr['code'] = '404';
            $jsonArr['message'] = $payload['message'];
            $this->sendJson($jsonArr);
        }
    }

}
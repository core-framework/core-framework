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

namespace Core\Request;

/**
 * The class that handles the incoming request to server
 *
 * @package Core\Request
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class Request
{
    /**
     * @var string The URL/query string (relative path)
     */
    private $path;
    /**
     * @var string The request method .i.e. GET, POST, PUT and DELETE
     */
    private $method;
    /**
     * @var array Contains the sanitized array of the global $_GET variable
     */
    private $getVars;
    /**
     * @var array Contains the sanitized array of the global $_POST variable
     */
    private $postVars;
    /**
     * @var array Contains the $_SERVER data from the request
     */
    private $server;
    /**
     * @var array Contains the cookie data from the request
     */
    private $cookies;
    /**
     * @var array An array of illegal characters
     */
    private $illegal = [
        '$',
        '*',
        '"',
        '\'',
        '<',
        '>',
        '^',
        '(',
        ')',
        '[',
        ']',
        '\\',
        '/',
        '!',
        '~',
        '`',
        '{',
        '}',
        '|',
        '%',
        '+',
        '-',
        '?php'
    ];
    /**
     * @var bool Defines if operating in development mode
     */
    private $devMode = false;

    /**
     * Request Constructor
     *
     * @param bool $devMode
     */
    public function __construct($devMode = false)
    {
        $this->devMode = $devMode;
        $this->getServerRequest();
    }

    /**
     * Builds the $_GET, $_POST, $_SERVER and $_COOKIE object properties
     */
    private function getServerRequest()
    {
        //get method
        $this->method = $_SERVER['REQUEST_METHOD'] ? strtolower($_SERVER['REQUEST_METHOD']) : strtolower(
            $_SERVER['HTTP_X_HTTP_METHOD']
        );
        if (empty($this->method)) {
            $this->method = "get";
        }

        //get POST vars && GET vars sanitized
        foreach ($_GET as $key => $value) {
            //$getVars[$key] = htmlentities(filter_var($val, FILTER_SANITIZE_STRING));
            switch ($key) {
                case 'email':
                    $this->getVars[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_EMAIL));
                    break;

                case 'phone':
                case 'mobile':
                    $this->getVars[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_NUMBER_INT));
                    break;

                default:
                    $this->getVars[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_STRING));
                    break;
            }
        }

        foreach ($_POST as $key => $value) {
            //$postVars[$key] = htmlentities(filter_var($val, FILTER_SANITIZE_STRING));
            switch ($key) {
                case 'email':
                    $this->postVars[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_EMAIL));
                    break;

                case 'phone':
                case 'mobile':
                    $this->postVars[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_NUMBER_INT));
                    break;

                default:
                    $this->postVars[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_STRING));
                    break;
            }
        }

        foreach ($_SERVER as $key => $value) {
            $this->server[$key] = $value;
        }

        foreach ($_COOKIE as $key => $value) {
            $this->cookies[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_STRING));
        }

        //path
        str_replace($this->illegal, '', $this->getVars['page']);
        $this->path = isset($this->getVars['page']) && $this->getVars['page'] != 'index.php' ? htmlentities(
            filter_var($_GET['page'], FILTER_SANITIZE_URL)
        ) : '';

    }


    /**
     * Returns an array of server info
     *
     * @return array
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Returns an array of Cookies set
     *
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * Returns the method used for the current request
     *
     * @return string
     */
    public function getRqstMethod()
    {
        return $this->method;
    }

    /**
     * Returns the url path/query string
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Returns an array of sanitized $_GET variables
     *
     * @return array
     */
    public function getGetVars()
    {
        return $this->getVars;
    }

    /**
     * Returns an array of sanitized $_POST variables
     *
     * @return array
     */
    public function getPostVars()
    {
        return $this->postVars;
    }

    /**
     * Sleep magic method
     *
     * @return array
     */
    public function __sleep()
    {
        return ['path', 'method', 'getVars', 'postVars', 'server', 'cookies', 'illegal', 'devMode'];
    }

}

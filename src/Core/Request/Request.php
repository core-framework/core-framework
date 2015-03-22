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

use Core\CacheSystem\Cacheable;

/**
 * The class that handles the incoming request to server
 *
 * <code>
 *  $request = DI::get('Request');
 * </code>
 *
 * @package Core\Request
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class Request implements Cacheable
{
    /**
     * @var string The URL/query string (relative path)
     */
    public $path;
    /**
     * @var string The request method .i.e. GET, POST, PUT and DELETE
     */
    public $method;
    /**
     * @var array Contains the sanitized array of the global $_GET variable
     */
    public $getVars;
    /**
     * @var array Contains the sanitized array of the global $_POST variable
     */
    public $postVars;
    /**
     * @var array Contains the $_SERVER data from the request
     */
    public $server;
    /**
     * @var array Contains the cookie data from the request
     */
    public $cookies;
    /**
     * @var bool Defines if operating in development mode
     */
    public $devMode = false;
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
        '!',
        '~',
        '`',
        '{',
        '}',
        '|',
        '%',
        '+',
        '?php'
    ];

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
        $rawPath = $this->getVars['page'];
        str_replace($this->illegal, '', $rawPath);
        $this->path = isset($rawPath) && $rawPath != 'index.php' ? $rawPath : '';

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

    /**
     * Magic wakup method. Initializes on unserialize
     */
    public function __wakeup()
    {

    }

}

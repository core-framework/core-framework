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
     * @var string The request httpMethod .i.e. GET, POST, PUT and DELETE
     */
    public $httpMethod;
    /**
     * @var array Contains the sanitized array of the global $_GET variable
     */
    public $GET;
    /**
     * @var array Contains the sanitized array of the global $_POST variable
     */
    public $POST;
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
    public $config;
    public $isAjax = false;
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
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (empty($config)) {
            trigger_error('Config is empty in ' . __CLASS__, E_USER_WARNING);
        }

        $this->config = $config;

        if (isset($config['$global']['devMode'])) {
            $this->devMode = $config['$global']['devMode'];
        }

        $this->getServerRequest();

    }

    /**
     * Builds the $_GET, $_POST, $_SERVER and $_COOKIE object properties
     */
    private function getServerRequest()
    {
        $config = $this->config;

        //get httpMethod
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ? strtolower($_SERVER['REQUEST_METHOD']) : strtolower(
            $_SERVER['HTTP_X_HTTP_METHOD']
        );

        if (empty($this->httpMethod)) {
            $this->httpMethod = "get";
        }

        if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH') === 'xmlhttprequest') {
            $this->isAjax = true;
        }

        //get POST vars && GET vars sanitized
        if (isset($config['$global']['sanitizeGlobals']) && $config['$global']['sanitizeGlobals'] === true) {
            $this->sanitizeGlobals();
        } else {
            $this->POST = $_POST;
            $this->GET = $_GET;
            $this->server = $_SERVER;
            $this->cookies = $_COOKIE;
        }

        $this->checkInput();

        //path
        $rawPath = isset($this->GET['page']) ? $this->GET['page'] : '';
        str_replace($this->illegal, '', $rawPath);
        $this->path = isset($rawPath) && $rawPath != 'index.php' ? $rawPath : '';

    }

    public function sanitizeGlobals()
    {
        $this->GET = $this->inputSanitize($_GET);

        $this->POST = $this->inputSanitize($_POST);

        $this->server = $_SERVER;

        foreach ($_COOKIE as $key => $value) {
            $this->cookies[$key] = htmlentities(
                filter_var(trim($value), FILTER_SANITIZE_STRING),
                ENT_COMPAT,
                'UTF-8',
                false
            );
        }
    }

    /**
     * Sanitize inputs
     *
     * @param $data
     * @return array
     */
    public function inputSanitize($data)
    {
        $sanitizedData = [];
        foreach ($data as $key => $val) {
            switch ($key) {
                case 'email':
                    $sanitizedData[$key] = htmlentities(
                        filter_var(trim($val), FILTER_SANITIZE_EMAIL),
                        ENT_COMPAT,
                        'UTF-8',
                        false
                    );
                    break;

                case 'phone':
                case 'mobile':
                $sanitizedData[$key] = htmlentities(
                    filter_var(trim($val), FILTER_SANITIZE_NUMBER_INT),
                    ENT_COMPAT,
                    'UTF-8',
                    false
                );
                    break;

                case 'data':
                    $sanitizedData[$key] = htmlentities(filter_var(trim($val), FILTER_UNSAFE_RAW));
                    break;

                default:
                    $sanitizedData[$key] = htmlentities(
                        filter_var(trim($val), FILTER_SANITIZE_STRING),
                        ENT_COMPAT,
                        'UTF-8',
                        false
                    );
                    break;
            }
        }

        return $sanitizedData;
    }

    /**
     * check for input (support for angular POST)
     *
     */
    public function checkInput()
    {
        $postData = file_get_contents("php://input");
        if (!empty($postData) && is_array($postData)) {
            $postData = $this->inputSanitize($postData);
            $this->POST['json'] = json_decode($postData);
        } elseif (!empty($postData) && is_string($postData)) {
            if ($this->httpMethod === 'put') {
                parse_str($postData, $this->POST['put']);
                $this->POST['put'] = $this->inputSanitize($this->POST['put']);
            }
        }
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
     * Returns the httpMethod used for the current request
     *
     * @return string
     */
    public function getRqstMethod()
    {
        return $this->httpMethod;
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
    public function getGET()
    {
        return $this->GET;
    }

    /**
     * Returns an array of sanitized $_POST variables
     *
     * @return array
     */
    public function getPOST()
    {
        return $this->POST;
    }

    /**
     * Sleep magic method
     *
     * @return array
     */
    public function __sleep()
    {
        return ['path', 'isAjax', 'illegal', 'devMode', 'config'];
    }

    /**
     * Magic wakup method. Initializes on unserialize
     */
    public function __wakeup()
    {
        $this->getServerRequest();
    }

}

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

namespace Core\Routes;


use Core\CacheSystem\Cacheable;
use Core\Request\Request;

/**
 * Class Router
 * @package Core\Routes
 */
class Router extends Request implements Cacheable
{

    /**
     * @var string The path/query string of the request
     */
    public $path;
    /**
     * @var array The path represented as an array split at '/', .i.e. /some/path would be ['some','path']
     */
    public $urlPathArr = [];
    /**
     * @var string The string that defines the Controller and Method associated with a given URL path, extracted from the route.conf
     */
    public $controllerVerb;
    /**
     * @var array Contains the array of the parameters set for a given path in the routes.conf file
     */
    public $routeVars;
    /**
     * Use Aesthetic Routing i.e if set to true route conf will not be taken into consideration and requested URI will determine the controller, like so - {baseWebsiteURI}/{Controller}/{method}/{arguments}
     *
     * @var bool
     */
    public $useAestheticRouting = false;
    /**
     * If a match for current requested Route (URI) was found
     *
     * @var bool
     */
    public $foundMatch = false;
    /**
     * Response array
     *
     * @var array
     */
    public $response = [];
    /**
     * Defined HTTP method
     *
     * @var string
     */
    public $definedMethod;
    /**
     * To serve html as is. For static site(s)/page(s)/content(s)
     *
     * @var bool
     */
    public $customServe;
    /**
     * Reference Path to the folder to serve as static content
     *
     * @var string
     */
    public $referencePath;
    /**
     * namespace strings
     *
     * @var string
     */
    public $namespace;
    /**
     * controller name
     *
     * @var string
     */
    public $controller;
    /**
     * method name
     *
     * @var string
     */
    public $method;
    /**
     * Arguments passed by the route
     *
     * @var array
     */
    public $args;
    /**
     * model name
     *
     * @deprecated Deprecated since version 3.0.0
     * @var string
     */
    public $model;
    /**
     * Requested filename
     *
     * @var string
     */
    public $fileName;
    /**
     * Requested file extension
     *
     * @var string
     */
    public $fileExt;
    /**
     * Global ($global) config
     *
     * @var array
     */
    public $global;
    /**
     * @var
     */
    public $resolvedArr;
    /**
     * @var array
     */
    public $config;
    /**
     * @var array Contains a collection of the defined routes in route.conf
     */
    private $collection;

    /**
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = $config;
        parent::__construct($config);
        $this->path = $this->getPath();
        $this->pathBurst();
        $this->loadRoutesConf($config);
    }


    /**
     * build the urlPathArr prop
     */
    private function pathBurst()
    {
        $path = $this->path;

        // If not empty, path is broken into segments array
        if (!empty($path))
        {
            $this->urlPathArr = explode('/', $path);
            $last_string = end($this->urlPathArr);

            // If requested URI is a file, fileName and extension are stored
            if (strpos($last_string, ".") > -1) {
                $pi = pathinfo($last_string);
                $this->fileName = $pi['filename'];
                $this->fileExt = $pi['extension'];
            }
        }
    }

    /**
     * Loads the router config
     *
     * @param array $config
     */
    private function loadRoutesConf(&$config = [])
    {
        // If Config is empty use Aesthetic Routing
        if (empty($config['$routes']) || (isset($config['$global']['useAestheticRouting']) && $config['$global']['useAestheticRouting'] === true))
        {
            $this->useAestheticRouting = true;
        }
        // Else store config components in variables
        else
        {
            $this->collection = $config['$routes'];
            $this->global = $config['$global'];
        }

    }

    /**
     * @param bool $useAestheticRouting
     * @return array
     * @throws \ErrorException
     */
    public function resolve($useAestheticRouting = false)
    {
        // If was previously resolved then return that computed Array
        if (!empty($this->resolvedArr)) {
            return $this->resolvedArr;
        }

        // Path is empty ? We're done resolve as root path (homepage)
        if (empty($this->path)) {

            $this->urlPathArr = ['/'];
            $this->pathVarsAssign($this->collection['/']);

        }
        // Use Aesthetic Routing ? if so we're done
        elseif ($useAestheticRouting === true) {

            $pathArr = explode("/", $this->path);
            $this->namespace = $namespace = '\\web\\Controllers';
            $this->routeVars = isset($this->config[$namespace . '\\' . $pathArr[1]]) ? $this->config[$namespace . '\\' . $pathArr[1]] : [];
            $this->controller = $pathArr[0] . 'Controller';
            $pathArr = array_shift($pathArr);
            $this->method = $pathArr[0] . 'Action';
            $pathArr = array_shift($pathArr);
            $this->args = $pathArr;

        }
        // Is there a literal match ? if so we're done
        elseif (isset($this->collection[$this->path])) {
            $this->pathVarsAssign($this->collection[$this->path]);
        }
        // If all else failed
        else {
            // Check If match can be found using RegEx
            $this->checkIfPatternMatch();

            // If no match was found then show page not found
            if ($this->foundMatch === false) {
                $this->namespace = '\\Core\\Controllers';
                $this->controller = 'errorController';
                $this->method = 'indexAction';
            }

        }

        $this->resolvedArr = $resolvedArr = [
            'namespace' => &$this->namespace,
            'controller' => &$this->controller,
            'method' => &$this->method,
            'args' => &$this->args,
            'routeVars' => &$this->routeVars
        ];

        return $resolvedArr;
    }

    /**
     * Sets the Namespace | Controller | method for the path.
     * Throws an exception if controller definition is not found
     *
     * @param $val
     * @throws \ErrorException
     */
    private function pathVarsAssign($val)
    {
        $urlPathArr = $this->urlPathArr;
        $this->routeVars = $val;

        // If http method was defined ? if not default assumes GET
        $this->definedMethod = !empty($val['httpMethod']) ? strtolower($val['httpMethod']) : 'get';

        if (isset($val['useAestheticRouting']) && $val['useAestheticRouting'] === true) {
            $this->namespace = '@appBase\\Controllers';
            $this->controller = $urlPathArr[0];
            $this->method = isset($urlPathArr[1]) ? $urlPathArr[1] : 'indexAction';
            if (sizeof($urlPathArr) > 2) {
                $this->args = array_slice($urlPathArr, 2);
            }
            return;
        }

        if (!empty($val['controller'])) {
            $controllerStr = $this->controllerVerb = $val['controller'];
            $strArr = explode(':', $controllerStr);
            if (!empty($strArr) && sizeof($strArr) >= 2) {
                $this->namespace = $strArr[0];
                $this->controller = $strArr[1];
                if (!empty($strArr[2])) {
                    $this->method = strpos($strArr[2], 'Action') < 0 ? $strArr[2] . "Action" : $strArr[2];
                } elseif (empty($strArr[2]) && !empty($urlPathArr[1]) && !is_numeric(
                        $urlPathArr[1]
                    ) && !in_array($urlPathArr[1], $this->args)
                ) {
                    $this->method = $urlPathArr[1] . "Action";
                } else {
                    $this->method = "indexAction";
                }
            } elseif (empty($strArr) && $val['serveAsIs'] === false) {

                throw new \ErrorException(
                    "Controller not defined OR definition broken. Must be of pattern `{namespace}:{controller}:{httpMethod}` ",
                    5,
                    1
                );
            }

        }

        if (!empty($val['serveAsIs']) && $val['serveAsIs'] === true) {
            $this->customServe = true;
            $this->referencePath = $val['referencePath'];

            return;
        }

    }

    /**
     *  check if URL (path) matches defined paths (pathConf file)
     */
    public function checkIfPatternMatch()
    {
        $path = $this->path;
        $collection = $this->collection;
        $foundMatch = &$this->foundMatch;

        // loop through route definitions in Route.conf.php file
        foreach ($collection as $key => $val) {

            // If key's value has parameter argReq
            if (isset($val['argReq']) && $foundMatch === false) {

                // Replace string conditions with RegEx
                $paramType = str_replace(array(':any', ':num', ':alpha'), array('[^/]+', '[0-9]+', '[\w]+'), $val['argReq']);

                // Build RegEx
                foreach ($paramType as $param => $pattern) {

                    $subject = isset($newKey) && $newKey !== "" ? $newKey : $key;
                    $newKey = preg_replace('#\{'.$param.'\}#', '(?P<'.$param.'>'.$pattern.')', $subject);
                }

                // reset key for next loop
                $urlPattern = $newKey;
                $newKey = "";

                // RegEx matches with path ? then we are done
                if (preg_match('#^'. $urlPattern . '$#', $path, $matches)) {
                    $this->foundMatch = true;
                    foreach($matches as $k => $v) {
                        if (is_numeric($k) === true) {
                            unset($matches[$k]);
                        }
                    }
                    $this->args = $matches;
                    $this->pathVarsAssign($val);
                }
            }

        }
    }

    /**
     * Sleep magic method
     *
     * @return array
     */
    public function __sleep()
    {
        $routerSleep = [
            'path',
            'urlPathArr',
            'controllerVerb',
            'routeVars',
            'collection',
            'useAestheticRouting',
            'foundMatch',
            'response',
            'definedMethod',
            'customServe',
            'referencePath',
            'namespace',
            'controller',
            'method',
            'args',
            'model',
            'fileName',
            'fileExt',
            'global',
            'resolvedArr',
            'config'
        ];

        return $routerSleep;
    }

    /**
     * Magic wakup method. Initializes on unserialize
     */
    public function __wakeup()
    {

    }
}
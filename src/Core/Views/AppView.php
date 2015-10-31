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

namespace Core\Views;

use Core\Application\Application;
use Core\CacheSystem\Cacheable;

/**
 * Class AppView
 * @package Core\Views
 */
class AppView implements viewInterface, Cacheable
{

    /**
     * HTTP status code
     *
     * @var int
     */
    public $httpStatus;

    /**
     * Show/include header section
     *
     * @var bool
     */
    public $showHeader = true;

    /**
     * Show/include footer section
     *
     * @var bool
     */
    public $showFooter = true;

    /**
     * Template directory path
     *
     * @var string
     */
    public $templateDir;

    /**
     * Template file to use
     *
     * @var string
     */
    public $template;

    /**
     * Debug template file location
     *
     * @var string
     */
    public $debugFile;

    /**
     * True if Application is currently running in debug mode
     *
     * @var bool
     */
    public $debugMode = false;

    /**
     * Disable view
     *
     * @var bool
     */
    public $disabled = false;

    /**
     * Layout template file
     *
     * @var string
     */
    public $layout = "root.tpl";

    /**
     * Base/core path of current project folder
     *
     * @var string
     */
    public $basePath;

    /**
     * Base application folder path (DocumentRoot)
     *
     * @var string
     */
    public $appPath;

    /**
     * Template Engine Object
     *
     * @var \Smarty
     */
    public $tplEngine;

    /**
     * Template variables
     *
     * @var array
     */
    public $tplInfo;

    /**
     * Test directory path
     *
     * @var string
     */
    public $httpTestsDir;

    /**
     * base Template directory path
     *
     * @var string
     */
    public $baseTemplateDir;

    /**
     * Cache Time to live (TTL)
     *
     * @var int
     */
    public $cache_lifetime;


    /**
     * View constructor
     *
     * @param null $tpl
     * @param array $conf
     */
    public function __construct($tpl = null, $conf = [])
    {
        if (isset($conf['tplType']) && $conf['tplType'] === 'tpl' && is_null($tpl)) {
            throw new \LogicException('tplType set as `tpl` but template Class not loaded');
        }

        if (empty($conf)) {
            $this->basePath = Application::getAlias('@base');
            $this->appPath = Application::getAlias('@web');
        } else {
            $this->basePath = $conf['basePath'];
            $this->appPath = $conf['appPath'];
        }

        $this->tplEngine = $tpl;
        $this->init();

    }

    /**
     * View Init
     */
    public function init()
    {
        $this->debugFile = $this->basePath . '/src/Core/Views/debug.php';
        $this->httpTestsDir = $this->basePath . '/src/Core/Tests/HttpTests/';
        $this->baseTemplateDir = $this->basePath . '/src/Core/Resources/BaseTemplates/';

        $this->tplEngine->left_delimiter = '<{';
        $this->tplEngine->right_delimiter = '}>';

        $this->tplEngine->setCompileDir($this->basePath . '/storage/smarty_cache/templates_c/');
        $this->tplEngine->setConfigDir($this->basePath . '/storage/smarty_cache/config/');
        $this->tplEngine->setCacheDir($this->basePath . '/storage/smarty_cache/cache/');
        $this->tplEngine->setTemplateDir($this->appPath . '/Templates/');
        $this->tplEngine->addTemplateDir($this->baseTemplateDir);
        $this->tplEngine->addTemplateDir($this->httpTestsDir);
        $this->tplEngine->assign('basePath', $this->basePath);
        $this->tplEngine->assign('appPath', $this->appPath);

        $this->tplEngine->inheritance_merge_compiled_includes = false;
        $this->tplEngine->caching = 1;
        $this->tplEngine->cache_lifetime = $this->cache_lifetime;
    }

    /**
     * Disables the View component
     */
    public function disable()
    {
        $this->disabled = true;
    }


    /**
     * Loads the debug html with data to be displayed
     *
     * @param bool $bool
     */
    public function setDebugMode($bool = true)
    {
        $this->debugMode = $bool;
    }

    /**
     * Set template variables
     *
     * @param $var
     * @param $val
     */
    public function setTemplateVars($var, $val)
    {
        if (strpos($var, '.') !== false) {
            $this->assignArrayByPath($this->tplInfo['vars'], $var, $val);
        } else {
            $this->tplInfo['varsCache'][$var] = $val;
            $this->tplEngine->assign($var, $val);
        }
    }

    /**
     * Allows the use of dot separated array key access in setTemplateVars
     *
     * @param $arr
     * @param $path
     * @param $value
     */
    public function assignArrayByPath(&$arr, $path, $value)
    {
        $keys = explode('.', $path);

        while ($key = array_shift($keys)) {
            $arr = &$arr[$key];
        }

        $arr = $value;
    }

    /**
     * Add Template directory
     *
     * @param $path
     */
    public function addTemplateDir($path)
    {
        $this->tplEngine->addTemplateDir($path);
    }

    /**
     * Sets current template to render
     *
     * @param $tpl
     */
    public function setTemplate($tpl)
    {
        $this->template = $tpl;
    }

    /**
     * Assigns new public parameters with given value
     *
     * @param $var
     * @param $val
     * @return mixed|void
     */
    public function set($var, $val)
    {
        $this->$var = $val;
    }

    /**
     * Sets the HTTP header status
     *
     * @param $val
     */
    public function setHeader($val)
    {
        $this->httpStatus = $val;
        Application::setHeaders($val);
    }

    /**
     * Gets the HTTP header status
     *
     * @return mixed
     */
    public function getHeader()
    {
        return $this->httpStatus;
    }

    /**
     *  Renders the current view
     */
    public function render()
    {
        if ($this->disabled === true) {
            return;
        }

        $tpl = $this->template;
        if (!$this->tplEngine->isCached($tpl)) {

            $tpl_exists = $this->tplEngine->templateExists($tpl);
            $this->tplInfo['vars']['showHeader'] = $this->showHeader;
            $this->tplInfo['vars']['showFooter'] = $this->showFooter;
            $this->tplEngine->assign('layout', $this->layout);
            $tplVars = $this->tplInfo['vars'];

            if ($this->debugMode) {
                $debugHtml = include_once $this->debugFile;
                $this->tplEngine->assign('debugHtml', $debugHtml);
            }

            if (!$tpl_exists) {
                $tpl = "errors/error404.tpl";
            } else {

                if ((!empty($tplVars) || sizeof($tplVars) !== 0)) {
                    $this->tplEngine->assign($tplVars);
                }

            }

        }

        $this->tplEngine->display($tpl);
    }

    /**
     * Magic sleep method to define properties to cache (serialize)
     *
     * @return array
     */
    public function __sleep()
    {
        return ['basePath', 'appPath', 'template', 'tplInfo', 'debugFile', 'debugMode', 'templateDir', 'baseTemplateDir'];
    }

    /**
     * Magic wakup method. Initializes on unserialize
     */
    public function __wakeup()
    {
        $this->tplEngine = Application::get('Smarty');
        $this->init();
        $this->tplEngine->assign($this->tplInfo['varsCache']);
    }

}
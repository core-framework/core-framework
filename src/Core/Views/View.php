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

use Core\CacheSystem\Cacheable;
use Core\DI\DI;

/**
 * This is the base view class in Core Framework
 *
 * <code>
 *
 *  $view = DI::get('View');
 *  //set template file
 *  $view->setTemplate('some.tpl')
 *  //set template var values
 *  $view->setTemplateVars('someKey', 'someValue');
 *  //OR
 *  $view->setTemplateVars('metas.somekey', 'someval');
 *  $view->setTemplateVars('metas.someotherkey', 'someotherval');
 *
 *  //Use In template file
 *  <{foreach from=$metas key=k item=v}>
 *      <{if not empty($v) }>
 *          <meta name="<{$k}>" content="<{$v}>" />
 *      <{/if}>
 *  <{/foreach}>
 *
 * </code>
 *
 * @package Core\Views
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class View implements viewInterface, Cacheable
{
    /**
     * @var bool Defines if View class is disabled from rendering
     */
    public $disabled = false;
    /**
     * @var bool Defines whether to include the header html
     */
    public $showHeader = true;
    /**
     * @var bool Defines whether to include the footer html
     */
    public $showFooter = true;
    /**
     * @var array Template info
     */
    public $tplInfo;
    /**
     * @var object Smarty instance
     */
    private $tplEngine;
    /**
     * @var string The template to render
     */
    private $tpl;
    /**
     * @var array Route parameters associated with the template
     */
    private $tplVars;
    /**
     * @var string Path to debug file, that contains load and memory info
     */
    private $debugfile;
    /**
     * @var string Debug file contents
     */
    private $debugDfltHtml;
    /**
     * @var bool Defines if current view is in Debug mode
     */
    private $debugMode;
    /**
     * @var string Path to Web App's template directory
     */
    private $templateDir;
    /**
     * @var string Path to base template files directory
     */
    private $baseTemplateDir;

    /**
     * @param \Smarty $tplEngine
     */
    public function __construct(\Smarty $tplEngine)
    {
        $this->tplEngine = $tplEngine;
        $this->init();
    }

    /**
     * Initiates tplEngine
     */
    public function init()
    {
        $this->debugfile = DS . "src" . DS . "Core" . DS . 'Views' . DS . "debug.php";
        $this->httpTestsDir = DS . "src" . DS . "Core" . DS . "Tests" . DS . "HttpTests" . DS;
        $this->baseTemplateDir = DS . "src" . DS . "Core" . DS . "Resources" . DS . "BaseTemplates" . DS;

        $this->tplEngine->left_delimiter = '<{';
        $this->tplEngine->right_delimiter = '}>';

        $this->tplEngine->setTemplateDir(_ROOT . $this->templateDir);
        $this->tplEngine->setCompileDir(_ROOT . DS . "src" . DS . "Core" . DS . 'smarty_cache' . DS . 'templates_c' . DS);
        $this->tplEngine->setConfigDir(_ROOT . DS . "src" . DS . "Core" . DS . 'smarty_cache' . DS . 'configs' . DS);
        $this->tplEngine->setCacheDir(_ROOT . DS . "src" . DS . "Core" . DS . 'smarty_cache' . DS . 'cache' . DS);
        $this->tplEngine->inheritance_merge_compiled_includes = false;
        //$this->testInstall();exit;
    }

    /**
     * Loads the debug html with data to be displayed
     *
     * @param bool $bool
     * @return mixed|void
     */
    public function setDebugMode($bool = true)
    {
        $this->debugMode = $bool;
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
     * Renders the final html output
     *
     * @return bool
     */
    public function render()
    {
        $this->tplEngine->addTemplateDir(_ROOT . $this->baseTemplateDir);
        $this->tplEngine->addTemplateDir(_ROOT . $this->httpTestsDir);
        if ($this->disabled === false) {
            $tplInfo = $this->tplInfo;
            $tpl = $this->tpl = $tplInfo['tpl'];
            $tpl_exists = $this->tplEngine->templateExists($tpl);
            $this->tplInfo['vars']['showHeader'] = $this->showHeader;
            $this->tplInfo['vars']['showFooter'] = $this->showFooter;
            $tplVars = $this->tplVars = $this->tplInfo['vars'];


            if ($this->debugMode) {
                $this->debugDfltHtml = include_once _ROOT . $this->debugfile;
                $this->tplEngine->assign('debugDfltHtml', $this->debugDfltHtml);
            }

            if (!$tpl_exists) {
                $tpl = "errors/error404.tpl";
            }

            if (!empty($tplVars) || sizeof($tplVars) !== 0) {
                foreach ($tplVars as $key => $val) {
                    $this->tplEngine->assign($key, $val);
                }
            }
            //$this->tplEngine->testInstall();
            $this->tplEngine->display($tpl);
        } else {
            return false;
        }
    }

    /**
     * Disables the view render method
     */
    public function disable()
    {
        $this->disabled = true;
    }

    /**
     * Set Template directory
     *
     * @param array|string $path
     * @return \Smarty|void
     */
    public function setTemplateDir($path)
    {
        $this->templateDir = $path;
        $this->tplEngine->addTemplateDir(_ROOT . $path);
    }

    /**
     * Set public properties
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->$key;
    }

    /**
     * Set template variables
     *
     * @param $var
     * @param $val
     */
    public function setTemplateVars($var, $val)
    {
        if(strpos($var, '.') !== false) {
            $this->assignArrayByPath($this->tplInfo['vars'], $var, $val);
        } else {
            $this->tplInfo['vars'][$var] = $val;
        }
    }

    /**
     * Allows the use of dot separated array key access in setTemplateVars
     *
     * @param $arr
     * @param $path
     * @param $value
     */
    public function assignArrayByPath(&$arr, $path, $value) {
        $keys = explode('.', $path);

        while ($key = array_shift($keys)) {
            $arr = &$arr[$key];
        }

        $arr = $value;
    }

    /**
     * Set template file to render
     *
     * @param $tpl
     */
    public function setTemplate($tpl)
    {
        $this->tplInfo['tpl'] = $tpl;
    }

    /**
     * Set header of http response
     *
     * @param $val
     */
    public function setHeader($val)
    {
        $this->tplInfo['header'] = $val;
    }

    /**
     * Returns the header
     *
     * @return mixed
     */
    public function getHeader()
    {
        if(isset($this->tplInfo['header'])){
            return $this->tplInfo['header'];
        }
        return false;
    }

    /**
     * Magic sleep method to define properties to cache (serialize)
     *
     * @return array
     */
    public function __sleep()
    {
        return ['tpl', 'tplInfo', 'tplVars', 'debugfile', 'templateDir', 'baseTemplateDir'];
    }

    /**
     * Magic wakup method. Initializes on unserialize
     */
    public function __wakeup()
    {
        $this->tplEngine = DI::get('Smarty');
        $this->init();
    }

}
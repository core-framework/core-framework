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

/**
 * This is the base view class in Core Framework
 *
 * @package Core\Views
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class view
{
    public $disabled = false;
    private $smarty;
    private $tpl;
    private $tplInfo;
    private $tplVars;
    private $debugfile;
    private $debugDfltHtml;
    private $debugMode;
    private $templateDir;
    private $baseTemplateDir;
    public  $showHeader = true;
    public  $showFooter = true;

    /**
     * View constructor
     */
    public function __construct()
    {
        $this->smarty_init();
    }

    /**
     * Initiates smarty
     */
    private function smarty_init()
    {
        $this->debugfile = DS . "src" . DS . "Core" . DS . 'Views' . DS . "debug.php";
        $this->httpTestsDir = DS . "src" . DS . "Core" . DS . "Tests" . DS . "HttpTests" . DS;
        $this->baseTemplateDir = DS . "src" . DS . "Core" . DS . "Resources" . DS . "BaseTemplates" . DS;
        $this->smarty = $smarty = new \Smarty();

        $smarty->left_delimiter = '<{';
        $smarty->right_delimiter = '}>';

        $smarty->setTemplateDir(_ROOT . $this->templateDir);
        $smarty->setCompileDir(_ROOT . DS . "src" . DS . "Core" . DS . 'smarty_cache' . DS . 'templates_c' . DS);
        $smarty->setConfigDir(_ROOT . DS . "src" . DS . "Core" . DS . 'smarty_cache' . DS . 'configs' . DS);
        $smarty->setCacheDir(_ROOT . DS . "src" . DS . "Core" . DS . 'smarty_cache' . DS . 'cache' . DS);
        $smarty->inheritance_merge_compiled_includes = false;
        //$smarty->testInstall();exit;
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
     * Assigns new public parameters with given value
     *
     * @param $var
     * @param $val
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
        $this->smarty->addTemplateDir(_ROOT . $this->baseTemplateDir);
        $this->smarty->addTemplateDir(_ROOT . $this->httpTestsDir);
        if ($this->disabled === false) {
            $tplInfo = $this->tplInfo;
            $tpl = $this->tpl = $tplInfo['tpl'];
            $tpl_exists = $this->smarty->templateExists($tpl);
            $this->tplInfo['vars']['showHeader'] = $this->showHeader;
            $this->tplInfo['vars']['showFooter'] = $this->showFooter;
            $tplVars = $this->tplVars = $this->tplInfo['vars'];


            if ($this->debugMode) {
                $this->debugDfltHtml = include_once _ROOT . $this->debugfile;
                $this->smarty->assign('debugDfltHtml', $this->debugDfltHtml);
            }

            if (!$tpl_exists) {
                $tpl = "errors/error404.tpl";
            }

            if (!empty($tplVars) || sizeof($tplVars) !== 0) {
                foreach ($tplVars as $key => $val) {
                    $this->smarty->assign($key, $val);
                }
            }
            //$this->smarty->testInstall();
            $this->smarty->display($tpl);
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
     * The directory where the .tpl files are located
     *
     * @param $path
     */
    public function setTemplateDir($path)
    {
        $this->templateDir = $path;
        $this->smarty->addTemplateDir(_ROOT . $this->templateDir);
    }

    /**
     * Sleep method
     *
     * @return array
     */
    public function __sleep()
    {
        return ['tpl', 'tplInfo', 'tplVars', 'debugfile', 'templateDir', 'baseTemplateDir'];
    }

    /**
     * Wakeup magic method
     */
    public function __wakeup()
    {
        $this->smarty_init();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 24/08/14
 * Time: 10:31 AM
 */

namespace Core\Views;

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

    public function __construct()
    {
        $this->smarty_init();
        $this->debugfile = DS . "src" . DS . "Core" . DS . 'Views' . DS . "debug.php";
        $this->httpTestsDir = DS . "src" . DS . "Core" . DS . "Tests" . DS . "HttpTests" . DS;
        $this->baseTemplateDir = DS . "src" . DS . "Core" . DS . "Resources" . DS . "BaseTemplates" . DS;
    }

    private function smarty_init()
    {
        $this->smarty = $smarty = new \Smarty();

        $smarty->left_delimiter = '<{';
        $smarty->right_delimiter = '}>';

        $smarty->setTemplateDir(_ROOT . $this->templateDir);
        $smarty->addTemplateDir(_ROOT . $this->baseTemplateDir);
        $smarty->setCompileDir(_ROOT . DS . "src" . DS . "Core" . DS . 'smarty_cache' . DS . 'templates_c' . DS);
        $smarty->setConfigDir(_ROOT . DS . "src" . DS . "Core" . DS . 'smarty_cache' . DS . 'configs' . DS);
        $smarty->setCacheDir(_ROOT . DS . "src" . DS . "Core" . DS . 'smarty_cache' . DS . 'cache' . DS);
    }

    public function debugMode($bool = true)
    {
        $this->debugMode = $bool;
        if ($this->debugMode) {
            $this->smarty->addTemplateDir(_ROOT . $this->httpTestsDir);
        }
    }

    public function set($var, $val)
    {
        $this->$var = $val;
    }

    public function render()
    {
        if ($this->disabled === false) {
            $tplInfo = $this->tplInfo;
            $tpl = $this->tpl = $tplInfo['tpl'];
            $tpl_exists = $this->smarty->templateExists($tpl);
            $tplVars = $this->tplVars = $this->tplInfo['vars'];

            if ($this->debugMode) {
                $this->debugDfltHtml = include_once _ROOT . $this->debugfile;
                $this->smarty->assign('debugDfltHtml', $this->debugDfltHtml);
            }

            if (!$tpl_exists) {
                $tpl = "BaseTemplates/errors/error404.tpl";
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

    public function disable()
    {
        $this->disabled = true;
    }

    public function setTemplateDir($path)
    {
        $this->templateDir = $path;
        $this->smarty->addTemplateDir(_ROOT . $this->templateDir);
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 11/02/15
 * Time: 1:24 AM
 */

namespace Core\Views;

use Core\Application\CoreApp;
use Core\CacheSystem\Cacheable;

class AppView implements viewInterface, Cacheable
{

    public $httpStatus;

    public $showHeader = true;

    public $showFooter = true;

    public $templateDir;

    public $template;

    public $debugFile;

    public $debugMode = false;

    public $disabled = false;

    public $layout = "root.tpl";

    public $basePath;

    public $appPath;

    /**
     * @var \Smarty
     */
    public $tplEngine;

    public $tplInfo;

    public $httpTestsDir;

    public $baseTemplateDir;

    public $cache_lifetime;


    public function __construct($tpl = null, $conf = [])
    {
        if (isset($conf['tplType']) && $conf['tplType'] === 'tpl' && is_null($tpl)) {
            throw new \LogicException('tplType set as `tpl` but template Class not loaded');
        }

        if (empty($conf)) {
            $this->basePath = CoreApp::getAlias('@base');
            $this->appPath = CoreApp::getAlias('@appBase');
        } else {
            $this->basePath = $conf['basePath'];
            $this->appPath = $conf['appPath'];
        }

        $this->tplEngine = $tpl;
        $this->init();

    }

    public function init()
    {
        $this->debugFile = $this->basePath . '/src/Core/Views/debug.php';
        $this->httpTestsDir = $this->basePath . '/src/Core/Tests/HttpTests/';
        $this->baseTemplateDir = $this->basePath . '/src/Core/Resources/BaseTemplates/';

        $this->tplEngine->left_delimiter = '<{';
        $this->tplEngine->right_delimiter = '}>';

        $this->tplEngine->setCompileDir($this->basePath . '/src/Core/smarty_cache/templates_c/');
        $this->tplEngine->setConfigDir($this->basePath . '/src/Core/smarty_cache/config/');
        $this->tplEngine->setCacheDir($this->basePath . '/src/Core/smarty_cache/cache/');
        $this->tplEngine->setTemplateDir($this->appPath . '/Templates/');
        $this->tplEngine->addTemplateDir($this->baseTemplateDir);
        $this->tplEngine->addTemplateDir($this->httpTestsDir);
        $this->tplEngine->assign('basePath', $this->basePath);
        $this->tplEngine->assign('appPath', $this->appPath);

        $this->tplEngine->inheritance_merge_compiled_includes = false;
        $this->tplEngine->caching = 1;
        $this->tplEngine->cache_lifetime = $this->cache_lifetime;
    }

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

    public function addTemplateDir($path)
    {
        $this->tplEngine->addTemplateDir($path);
    }

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

    public function setHeader($val)
    {
        $this->httpStatus = $val;
        CoreApp::$app->setHeaders($val);
    }

    public function getHeader()
    {
        return $this->httpStatus;
    }

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
        return [];
    }

    /**
     * Magic wakup method. Initializes on unserialize
     */
    public function __wakeup()
    {

    }

}
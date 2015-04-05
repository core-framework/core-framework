<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 06/02/15
 * Time: 6:32 PM
 */

namespace Core\Application;

use Core\DI\DI;

class Components extends DI
{

    public $basePath;

    public $appPath;

    public $conf;

    public $global;

    public $tplType = 'tpl'; // 'tpl' || 'html' || 'php'

    public $baseComponents = [];

    /**
     * @var \Core\Routes\Router $router
     */
    public $router;

    /**
     * @var \Core\Controllers\Controller
     */
    public $controller;

    public $view;

    /**
     * @var \Core\CacheSystem\Cache
     */
    public $cache;

    public function __construct()
    {

    }

    public function loadConf($conf = [])
    {

        if (!empty($conf)) {
            $this->basePath = CoreApp::$basePath = realpath($conf['$global']['basePath']);
            $this->appPath = CoreApp::$appPath = realpath($conf['$global']['appPath']);
            CoreApp::addAlias('@base', $this->basePath);
            CoreApp::addAlias('@appBase', $this->appPath);
            unset($conf['$global']['basePath'], $conf['$global']['appPath']);
            $this->conf = $conf;
            $this->global = &$this->conf['$global'];
            if (isset($conf['$components'])) {
                $this->baseComponents = array_merge($conf['$components'], $this->baseComponents);
            }
        }

    }

    public function loadComponents()
    {
        $di = $this;
        if (isset($this->global['useAPC']) && $this->global['useAPC'] === true) {
            $hasAPC = $this->global['hasAPC'];
            if ($hasAPC === false) {
                throw new \LogicException('`useAPC` is set to TRUE but not installed or enabled in php ini.');
            }

            $di->register('Cache', '\\Core\\CacheSystem\\OPCache');

        } else {
            $di->register('Cache', '\\Core\\CacheSystem\\Cache');
        }

        $di->register('Config', function () {
            return $this->conf;
        });

        $di->register('Router', '\\Core\\Routes\\Router')
            ->setArguments(array($this->conf));

        if (isset($this->global['tplType']) && $this->tplType = $this->global['tplType'] === 'tpl') {

            $di->register('View', '\\Core\\Views\\AppView')
                ->setArguments(array('Smarty'));
            $di->register('Smarty', '')
                ->setDefinition(
                    function () {
                        return new \Smarty();
                    }
                );

        } else {

            // TODO: create/add other possible template types
            //Plug other template types here (as View)
            //$di->register('View', '\\Core\\Views\\AppView');

        }

        if (empty($this->baseComponents)) {
            return;
        }

        $baseComponents = $this->baseComponents;
        foreach ($baseComponents as $class => $definition) {
            if (is_array($definition)) {
                $this->register($class, $definition['definition'])->setArguments($definition['dependencies']);
            } else {
                $this->register($class, $definition);
            }
        }
    }
}



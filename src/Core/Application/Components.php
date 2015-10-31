<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 06/02/15
 * Time: 6:32 PM
 */

namespace Core\Application;

use Core\DI\DI;

/**
 * Class Components
 * @package Core\Application
 */
class Components extends DI
{
    /**
     * Application base/root path
     *
     * @var string
     */
    public static $basePath;

    /**
     * Application folder path
     *
     * @var string
     */
    public static $appPath;

    /**
     * Application config
     *
     * @var array
     */
    public $conf;

    /**
     * A part of $conf
     *
     * @var array
     */
    public $global;

    /**
     * Template type
     *
     * @var string
     */
    public $tplType = 'tpl'; // 'tpl' || 'html' || 'php'

    /**
     * Array of base/core Components
     *
     * @var array
     */
    public $baseComponents = [];

    /**
     * Router object
     *
     * @var \Core\Routes\Router $router
     */
    public $router;

    /**
     * Controller object
     *
     * @var \Core\Controllers\BaseController
     */
    public $controller;

    /**
     * View Object
     *
     * @var \Core\Views\AppView
     */
    public $view;

    /**
     * Cache object
     *
     * @var \Core\CacheSystem\AppCache
     */
    public $cache;

    /**
     * Contains the class maps
     *
     * @var array
     */
    public static $classmap;

    /**
     * Class map aliases
     *
     * @var array
     */
    public static $alias = [
        '@Core' => '@base/src/Core',
        '@web' => '@base/web'
    ];

    /**
     * object Constructor
     */
    public function __construct() { }

    /**
     * loads component objects
     *
     * @throws \ErrorException
     */
    public function getComponents()
    {
        $this->baseComponents = $this->conf['$components'];

        if (empty($this->baseComponents)) {
            return;
        }

        $baseComponents = $this->baseComponents;
        foreach ($baseComponents as $class => $definition) {
            if (is_array($definition) && $class != "commands") {
                $this->register($class, $definition['definition'])->setArguments($definition['dependencies']);
            } else {
                $this->register($class, $definition);
            }
        }
    }


    /**
     * loads configurations
     *
     * @param array $conf
     */
    public function loadConf($conf = [])
    {
        if (!empty($conf)) {
            static::$basePath = $conf['$global']['basePath'];
            static::$appPath = $conf['$global']['appPath'];
            static::addAlias('@base', static::$basePath);
            static::addAlias('@web', static::$appPath);
            $this->conf = $conf;
            $this->global = &$this->conf['$global'];
            if (isset($conf['$components']) && !empty($conf['$components'])) {
                $this->baseComponents = array_merge($conf['$components'], $this->baseComponents);
            }
        }

    }


    /**
     * Application auto loader
     *
     * @param $class
     */
    public static function autoload($class)
    {
        if (static::$classmap[$class]) {
            $classFile = static::$classmap[$class];
            if (strpos($classFile, '@') === -1) {
                include $classFile;
                return;
            }
        } elseif (strpos($class, '\\') !== false) {
            $classFile = '@' . str_replace('\\', '/', $class);
        } else {
            return;
        }

        $realPath = self::getRealPath($classFile);

        if (!is_readable($realPath)) {
            return;
        }

        include $realPath;
    }

    /**
     * Get real path from provided aliased path
     *
     * @param $aliasPath
     * @return string
     */
    public static function getRealPath($aliasPath)
    {
        $alias = substr($aliasPath, 0, strpos($aliasPath, '/'));
        $relativePath = substr($aliasPath, strpos($aliasPath, '/'));

        $realPath = self::getAlias($alias) . $relativePath . '.php';
        return $realPath;
    }

    /**
     * Alias to path conversion
     *
     * @param $aliasKey
     * @return string
     */
    public static function getAlias($aliasKey)
    {
        if ($aliasKey === '@base') {
            return self::$basePath;
        }

        if (isset(self::$alias[$aliasKey])) {
            $aliasVal = self::$alias[$aliasKey];
        } else {
            return;
        }

        if (strpos($aliasVal, '@') > -1) {
            $newAlias = substr($aliasVal, 0, strpos($aliasVal, '/'));
            $newAliasVal = substr($aliasVal, strpos($aliasVal, '/'));
            $aliasVal = self::getAlias($newAlias) . $newAliasVal;
        }

        return $aliasVal;
    }

    /**
     * Add alias
     *
     * @param $aliasName
     * @param $path
     */
    public static function addAlias($aliasName, $path)
    {
        self::$alias[$aliasName] = $path;
    }

}



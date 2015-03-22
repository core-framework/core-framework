<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 07/02/15
 * Time: 10:28 AM
 */

namespace Core\Application;


class BaseCoreApp
{

    public static $app;

    public static $classmap;

    public static $basePath;

    public static $appPath;

    public static $alias = [
        '@Core' => '@base/src/Core',
        '@web' => '@base/web'
    ];

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
            //\ComposerAutoloaderInit5a551ebbf056947890c145e646535d1e::loadClassLoader($class);

            return;
        }

        $realPath = self::getRealPath($classFile);

        if (!is_readable($realPath)) {
            //\ComposerAutoloaderInit5a551ebbf056947890c145e646535d1e::loadClassLoader($class);
            return;
        }

        include $realPath;
    }

    public static function getRealPath($aliasPath)
    {
        $alias = substr($aliasPath, 0, strpos($aliasPath, '/'));
        $relativePath = substr($aliasPath, strpos($aliasPath, '/'));

        $realPath = self::getAlias($alias) . $relativePath . '.php';
        return $realPath;
    }

    public static function getAlias($aliasKey)
    {
        if ($aliasKey === '@base') {
            return self::$basePath;
        }

        $aliasVal = self::$alias[$aliasKey];

        if (strpos($aliasVal, '@') > -1) {
            $newAlias = substr($aliasVal, 0, strpos($aliasVal, '/'));
            $newAliasVal = substr($aliasVal, strpos($aliasVal, '/'));
            $aliasVal = self::getAlias($newAlias) . $newAliasVal;
        }

        return $aliasVal;
    }

    public static function addAlias($aliasName, $path)
    {
        self::$alias[$aliasName] = $path;
    }


}
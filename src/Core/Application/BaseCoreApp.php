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

namespace Core\Application;

/**
 * Base CoreFramework application
 *
 * Class BaseCoreApp
 * @package Core\Application
 */
abstract class BaseCoreApp
{
    /**
     * Contains base Application
     *
     * @var BaseApplication
     */
    public static $app;

    /**
     * Contains the class maps
     *
     * @var array
     */
    public static $classmap;

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
     * Class map aliases
     *
     * @var array
     */
    public static $alias = [
        '@Core' => '@base/src/Core',
        '@web' => '@base/web'
    ];

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
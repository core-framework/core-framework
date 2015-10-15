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

namespace Core\Config;


class AppConfig
{
    public static $confSrcPath;
    public static $confEditablePath;
    public static $allConfPath;
    public static $allConf;

    public function __construct($conf = null)
    {
        if (is_null($conf)) {
            $conf = _ROOT . "/web/config/editable.conf.php";
        }

        static::configure($conf);
        return $this;
    }

    public static function setFile($filePath)
    {
        if (!is_readable($filePath)) {
            throw new \InvalidArgumentException("Given argument must be a readable file path.");
        }
        return new AppConfig($filePath);
    }

    public static function addConf($name, array $confArr)
    {
        static::$allConf[$name] = $confArr;
    }

    public static function setConf(array $confArr)
    {
        static::$allConf = $confArr;
    }

    public static function setEditableConfFile($filePath)
    {
        static::$confEditablePath = $filePath;
    }

    public static function store($arr = [])
    {
        $filePath = static::$confEditablePath;

        if (empty($arr)) {
            throw new \InvalidArgumentException("Nothing to save!");
        }

        if (!is_array($arr)) {
            throw new \InvalidArgumentException("Given argument must be an Array.");
        }

        if (!isset($filePath)) {
            throw new \LogicException("Editable config file not provided.");
        }

        if (!is_readable($filePath)) {
            throw new \LogicException("Provided config file is not readable.");
        }

        static::putFileContent($filePath, $arr);
    }

    public static function getFileContent($filePath)
    {
        if (is_readable($filePath)) {
            $orgData = include $filePath;
        } else {
            $orgData = [];
        }
        return $orgData;
    }

    public static function putFileContent($filePath, $putArr = [])
    {
        if (!is_array($putArr)) {
            throw new \InvalidArgumentException("Content to put in file must be an Array.");
        }

        if (empty($putArr)) {
            throw new \InvalidArgumentException("Nothing to put in file.");
        }

        if (!is_readable($filePath) || !is_writable($filePath)) {
            throw new \InvalidArgumentException("Given file not readable Or writable.");
        }

        $orgContentArr = static::getFileContent($filePath);
        try {
            $perms = substr(decoct(fileperms($filePath)),2);
            chmod($filePath, 0777);
            $newArr = array_merge($putArr, $orgContentArr);
            $data = '<?php return ' . var_export($newArr, true) . ";\n ?>";
            file_put_contents($filePath, $data);
            chmod($filePath, octdec($perms));
        } catch (\Exception $e) {
            throw new \ErrorException($e->getMessage());
        }
    }

    private static function configure($conf)
    {
        if (is_array($conf)) {
            static::$allConf = $conf;
        } elseif (is_string($conf) && is_file($conf) && is_readable($conf)) {
            static::$confSrcPath = $conf;
            $confArr = include $conf;
            if (!is_array($confArr)) {
                throw new \InvalidArgumentException(
                    "Expected contents of file to be array, " . gettype($confArr) . " given."
                );
            }
            static::$allConf = $confArr;
        } elseif (!is_readable($conf)) {
            throw new \InvalidArgumentException("Unable to read file " . $conf);
        } else {
            throw new \InvalidArgumentException("Config must be a readable file or array");
        }
    }
}
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

namespace Core\Helper;

/**
 * Helper class for some common handy methods
 *
 * @package Core\Helper
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class helper
{
    /**
     * Method to serialize array (comma separated values as single string)
     *
     * @param array $arr
     * @return string
     */
    public static function serialize(array $arr)
    {
        $serialized = "";
        if (!key($arr)) {
            foreach ($arr as $item) {
                $serialized .= $item . ", ";
            }
            $serialized = rtrim($serialized, ", ");
            return $serialized;
        } elseif (sizeof(key($arr)) > 0) {
            foreach ($arr as $key => $val) {
                $serialized .= $val . ", ";
            }
            $serialized = rtrim($serialized, ", ");
            return $serialized;
        }
    }

    /**
     * Method to copy files and directories recursively
     *
     * @param $source
     * @param $dest
     * @param bool $override
     * @throws \Exception
     */
    public static function copyr($source, $dest, $override = false)
    {
        $dir = opendir($source);
        if (!is_dir($dest)) {
            mkdir($dest);
        } else {
            chmod($dest, 0755);
        }
        if (is_resource($dir)) {
            while (false !== ($file = readdir($dir))) {
                if (($file != '.') && ($file != '..')) {
                    if (is_dir($source . DS . $file)) {
                        self::copyr($source . DS . $file, $dest . DS . $file);
                    } elseif (is_readable($dest . DS . $file) && $override === true) {
                        copy($source . DS . $file, $dest . DS . $file);
                    } elseif (!is_readable($dest . DS . $file)) {
                        copy($source . DS . $file, $dest . DS . $file);
                    }
                }
            }
        } else {
            throw new \Exception("readdir() expects parameter 1 to be resource", 10);
        }
        closedir($dir);
    }

    /**
     * Method to change the permission for files recursively
     *
     * @param $dir
     * @param null $mod
     * @param bool $recursive
     */
    public static function chmodDirFiles($dir, $mod = null, $recursive = true)
    {
        chmod($dir, 0755);
        if ($recursive && $objs = glob($dir . DS . "*")) {
            foreach ($objs as $file) {
                if (is_dir($file)) {
                    self::chmodDirFiles($file, $mod, $recursive);
                } else {
                    self::change_perms($file, $mod);
                }
            }
        }
    }

    /**
     * Method to change the permission of a single file
     *
     * @param $obj
     * @param null $mod
     */
    public static function change_perms($obj, $mod = null)
    {
        chmod($obj, empty($mod) ? 0755 : $mod);
    }

} 
<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Helper;


class helper
{
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

    public static function change_perms($obj, $mod = null)
    {
        chmod($obj, empty($mod) ? 0755 : $mod);
    }

} 
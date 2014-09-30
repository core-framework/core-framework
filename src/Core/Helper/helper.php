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

    public static function copyr($source, $dest)
    {
        $dir = opendir($source);
        @mkdir($dest);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($source . '/' . $file)) {
                    self::copyr($source . '/' . $file, $dest . '/' . $file);
                } else {
                    copy($source . '/' . $file, $dest . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public static function chmodDir($dir, $mod = null, $recursive = true)
    {
        chmod($dir, 0755);
        if ($recursive && $objs = glob($dir . DS . "*")) {
            foreach ($objs as $file) {
                if (is_dir($file)) {
                    self::chmodDir($file, $mod, $recursive);
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
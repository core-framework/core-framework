<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Core\Scripts;

define('DS', DIRECTORY_SEPARATOR);
use Composer\Script\Event;

/**
 * @author Shalom Sam <shalom.s@coreframework.in>
 * Class controller
 * @package Core\Controllers
 */
class installer {
    public static function install(Event $event){

        $currentDir = getcwd();
        chdir('../../../');
        $nowDir = getcwd();
        echo $currentDir;
        echo $nowDir;
        var_dump($event);
    }
} 
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
use Composer\Console\HtmlOutputFormatter;

/**
 * @author Shalom Sam <shalom.s@coreframework.in>
 * Class controller
 * @package Core\Controllers
 */
class installer {
    public static function install(Event $event){

        $callback = (function($arg){
            if(is_dir($arg)){
                return true;
            }else{
                return;
            }
        });

        $composer = $event->getComposer();
        $IO = $event->getIO();
        $currentDir = getcwd();

        $resp = $IO->ask('Is `'.$currentDir.'` the path to project root? :', true);
        var_dump($resp);
        if($resp === false || strtolower($resp) === 'no'){
            $resp2 = $IO->askAndValidate('Please enter the path to project root :', $callback ,3);
            define('_pROOT', $resp2);
        }else{
            define('_pROOT', $currentDir);
        }
        print_r(_pROOT);

    }

}


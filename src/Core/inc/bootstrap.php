<?php

use Core\DI\DI;

define('_SRC_DIR', "src");
define('_CORE', _ROOT . DS . _SRC_DIR . DS . "Core");
define('DS', DIRECTORY_SEPARATOR);

$loader = require_once _ROOT . DS . "vendor" . DS . "autoload.php";


$di = new DI();
$di->register('Cache', '\\Core\\CacheSystem\\Cache');
$di->register('Config', '\\Core\\Config\\Config');
$di->register('Helper', '\\Core\\Helper\\Helper');
$di->register('Request', '\\Core\\Request\\Request');
$di->register('Route', '\\Core\\Routes\\Routes')
    ->setArguments(array('Request', 'Config'));
$di->register('View', '\\Core\\Views\\View')
    ->setArguments(array('Smarty'));
$di->register('Smarty', '\\Smarty')
    ->setDefinition(function(){
            return new Smarty();
        });

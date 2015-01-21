<?php

use Core\DI\DI;

$di = new DI();
$di->register('Cache', '\\Core\\CacheSystem\\Cache');
$di->register('Config', '\\Core\\Config\\Config');
$di->register('Helper', '\\Core\\Helper\\Helper');
$di->register('IOStream', '\\Core\\Scripts\\IOStream');
$di->register('CLI', "\\Core\\Scripts\\CLI")
    ->setArguments(array('IOStream', 'Config'));
$di->register('Core', "\\Core\\Scripts\\Core")
    ->setArguments(array('IOStream', 'Config'));
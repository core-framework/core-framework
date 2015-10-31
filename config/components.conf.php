<?php


$components = [

    'Cache' => \Core\CacheSystem\AppCache::class,

    'Config' => \Core\Config\AppConfig::class,

    'Router' => \Core\Routes\Router::class,

    'Controller' => \Core\Controllers\BaseController::class,

    'View' => [
        'definition' => \Core\Views\AppView::class,
        'dependencies' => [ 'Smarty' ]
    ],

    'Smarty' => \Smarty::class
];

return $components;
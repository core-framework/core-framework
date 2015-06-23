<?php

/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Routes config
 */
return $routes = [


    '/' => [
        'pageName' => 'homepage',
        'pageTitle' => 'Core Framework - A new PHP framework',
        'controller' => '\\web\\Controllers:siteController:indexAction',
        'metas' => [
            'keywords' => 'core, php, framework, CoreFramework, CorePHPFramework, Core Framework, Shalom, Sam',
            'description' => 'CoreFramework is brand new php framework',
            'author' => 'Shalom Sam'
        ]
    ],

    '/about' => [
        'pageName' => 'about',
        'pageTitle' => 'Core Framework - About page',
        'controller' => '\\web\\Controllers:siteController:aboutAction'
    ],

    '/get_started' => [
        'pageName' => 'getStarted',
        'pageTitle' => 'Core Framework - Get Started',
        'controller' => '\\web\\Controllers:siteController:getstartedAction'
    ],

    '/documentation' => [
        'pageName' => 'demo',
        'pageTitle' => 'Demo about Page',
        'controller' => '\\web\\Controllers:siteController:documentationAction'
    ],

    '/documentation/api' => [
        'pageName' => 'api',
        'pageTitle' => 'Core Framework - API',
        'serveAsIs' => true,
        'serveIframe' => true,
        'referencePath' => '/documentation/api/index.html',
        'controller' => '\\web\\Controllers:siteController:apiAction',
        'showHeader' => true
    ],

    '/documentation/api/{page}' => [
        'pageName' => 'api',
        'argReq' => ['page' => '[\S]'],
        'argDefault' => 'index.html',
        'httpMethod' => 'GET',
        'serveAsIs' => true,
        'referencePath' => 'Templates/api',
        'controller' => '\\web\\Controllers:siteController:apiAction',
        'showHeader' => false,
        'showFooter' => false
    ],

    '/documentation/{page}' => [
        'pageName' => 'Documentation',
        'pageTitle' => 'Core Framework - Documentation',
        'argReq' => ['page' => '[\w]'],
        'argDefault' => '',
        'httpMethod' => 'GET',
        'controller' => '\\web\\Controllers:siteController:documentationAction',
        'metaAndTitleFromFile' => true,
        'metaFile' => 'metas/metas.php'
    ],

    '/download' => [
        'pageName' => 'Download',
        'pageTitle' => 'Core Framework - Download',
        'controller' => '\\web\\Controllers:siteController:downloadAction'
    ]
];
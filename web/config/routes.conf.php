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
return $routes = array(


    '/' => array(
        'pageName' => 'homepage',
        'pageTitle' => 'Core Framework - A new PHP framework',
        'controller' => '\\web\\Controllers:siteController:indexAction',
        'metas' => array(
            'keywords' => 'core, php, framework, CoreFramework, CorePHPFramework, Core Framework, Shalom, Sam',
            'description' => 'CoreFramework is brand new php framework',
            'author' => 'Shalom Sam'
        )
    ),

    '/about' => array(
        'pageName' => 'about',
        'pageTitle' => 'Core Framework - About page',
        'controller' => '\\web\\Controllers:siteController:aboutAction'
    ),

    '/get_started' => array(
        'pageName' => 'getStarted',
        'pageTitle' => 'Core Framework - Get Started',
        'controller' => '\\web\\Controllers:siteController:getstartedAction'
    ),

    '/documentation' => array(
        'pageName' => 'documentation',
        'pageTitle' => 'Core Framework - Documentation',
        'controller' => '\\web\\Controllers:siteController:documentationAction'
    ),

    '/contribute' => array(
        'pageName' => 'contribute',
        'pageTitle' => 'Core Framework - Contribute',
        'controller' => '\\web\\Controllers:siteController:contributeAction'
    ),

    '/documentation/api' => array(
        'pageName' => 'api',
        'pageTitle' => 'Core Framework - API',
        'serveAsIs' => true,
        'serveIframe' => true,
        'referencePath' => '/documentation/api/index.html',
        'controller' => '\\web\\Controllers:siteController:apiAction',
        'showHeader' => true
    ),

    '/documentation/api/{page}' => array(
        'pageName' => 'api',
        'argReq' => array('page' => ':any'),
        'argDefault' => 'index.html',
        'httpMethod' => 'GET',
        'serveAsIs' => true,
        'referencePath' => 'Templates/api',
        'controller' => '\\web\\Controllers:siteController:apiAction',
        'showHeader' => false,
        'showFooter' => false
    ),

    '/documentation/api/resources/{file}' => array(
        'argReq' => array('file' => ':any'),
        'argDefault' => '',
        'httpMethod' => 'GET',
        'serveAsIs' => true,
        'referencePath' => 'Templates/api/resources',
        'controller' => '\\web\\Controllers:siteController:apiAction',
        'showHeader' => false,
        'showFooter' => false
    ),

    '/documentation/{page}' => array(
        'pageName' => 'Documentation',
        'pageTitle' => 'Core Framework - Documentation',
        'argReq' => array('page' => ':alpha'),
        'argDefault' => '',
        'httpMethod' => 'GET',
        'controller' => '\\web\\Controllers:siteController:documentationAction',
        'metaAndTitleFromFile' => true,
        'metaFile' => 'metas/metas.php'
    ),

    '/download' => array(
        'pageName' => 'Download',
        'pageTitle' => 'Core Framework - Download',
        'controller' => '\\web\\Controllers:siteController:downloadAction'
    )
);
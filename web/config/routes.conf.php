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
        'controller' => '\\web\\Controllers:siteController:aboutAction',
        'metas' => array(
            'keywords' => 'core, php, framework, CoreFramework, CorePHPFramework, Core Framework, Shalom, Sam',
            'description' => 'CoreFramework is brand new php framework',
            'author' => 'Shalom Sam'
        )
    ),

    '/get_started' => array(
        'pageName' => 'getStarted',
        'pageTitle' => 'Core Framework - Get Started',
        'controller' => '\\web\\Controllers:siteController:getstartedAction',
        'metas' => array(
            'keywords' => "core, framework, Core Framework, CoreFramework, php, php framework, getting started with CoreFramework, composer, web application development, setting up web application, web application framework, bower, bower install, web frameworks, web development tool, application development, web",
            'description' => "Get started with developing your web application using Core Framework, that makes web application development easy and a breeze"
        )
    ),

    '/documentation' => array(
        'pageName' => 'documentation',
        'pageTitle' => 'Core Framework - Documentation',
        'controller' => '\\web\\Controllers:siteController:documentationAction',
        'metas' => array(
            'keywords' => "core, framework, Core Framework, CoreFramework, php, php framework, documentation for CoreFramework, composer, web application development, setting up web application, documentation, web development, php application development",
            'description' => "Documentation with detailed step-by-step actions to help you with web application development and maintenance, helping you focus on what matters"
        )
    ),

    '/contribute' => array(
        'pageName' => 'contribute',
        'pageTitle' => 'Core Framework - Contribute',
        'controller' => '\\web\\Controllers:siteController:contributeAction',
        'metas' => array(
            'keywords' => "core, framework, Core Framework, CoreFramework, php, php framework, documentation for CoreFramework, composer, web application development, setting up web application, documentation, web development, php application development, contribute",
            'description' => "Contribute and become a part of Core Framework. A start to great things on the web."
        )
    ),

    '/documentation/api' => array(
        'pageName' => 'api',
        'pageTitle' => 'Core Framework - API',
        'serveAsIs' => true,
        'serveIframe' => true,
        'referencePath' => '/documentation/api/index.html',
        'controller' => '\\web\\Controllers:siteController:apiAction',
        'showHeader' => true,
        'metas' => array(
            'keywords' => "core, framework, Core Framework, CoreFramework, php, php framework, documentation for CoreFramework, composer, web application development, setting up web application, documentation, web development, php application development, Core Framework API, API",
            'description' => "Complete list of available APIs for Core Framework"
        )
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
        'showFooter' => false,
        'metaAndTitleFromFile' => true,
        'metaFile' => 'metas/metas.php'
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
        'controller' => '\\web\\Controllers:siteController:downloadAction',
        'metas' => array(
            'metaKeywords' => "core, framework, Core Framework, CoreFramework, php, php framework, composer, git, CoreFramework download setup, download setup, install, setup, download & install, CoreFramework download & install, CoreFramework install",
            'metaDescription' => "Instructions to help you download, install and setup your web application for easy development using CoreFramework php framework"
        )
    )
);
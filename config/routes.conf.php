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
        'pageName' => 'demo',
        'pageTitle' => 'Demo Home Page',
        'controller' => '\\web\\Controllers:siteController:indexAction',
        'metas' => [
            'keywords' => 'test, keywords, for test',
            'description' => 'This is a test description',
            'author' => 'Shalom Sam'
        ]
    ],

    '/about' => [
        'pageName' => 'demo',
        'pageTitle' => 'Demo about Page',
        'controller' => '\\web\\Controllers:siteController:aboutAction'
    ],

    '/user/register' => [
        'httpMethod' => 'POST',
        'controller' => '\\web\\Controllers:siteController:registerAction',
        'noCache' => true
    ],

    '/user/login' => [
        'httpMethod' => 'POST',
        'controller' => '\\web\\Controllers:siteController:loginAction',
        'noCache' => true
    ],

    '/user/logout' => [
        'httpMethod' => 'GET',
        'controller' => '\\web\\Controllers:siteController:logoutAction',
        'noCache' => true
    ],

    '/test/helloworld' => [
        'pageName' => 'test',
        'pageTitle' => 'Test',
        'httpMethod' => 'GET',
        'controller' => '\\Core\\Controllers:testController:helloWorldAction'
    ],
    '/test/hello/{name}' => [
        'pageName' => 'test',
        'pageTitle' => 'Test',
        'argReq' => ['name' => ':alpha'],
        'argDefault' => 'name',
        'httpMethod' => 'GET',
        'controller' => '\\Core\\Controllers:testController'
    ],

    '/testing/{id}' => [
        'pageName' => 'testing',
        'pageTitle' => 'Testing',
        'argReq' => ['id' => ':num'],
        'argDefault' => '1',
        'httpMethod' => 'GET',
        'controller' => '\\Core\\Controllers:testController'
    ],

    'testingmulti/{id}/someMethod/{slug}' => [
        'pageName' => 'test',
        'pageTitle' => 'Test',
        'argReq' => ['id' => ':num', 'slug' => ':alpha'],
        'argDefault' => ['id' => '1', 'slug' => 'awesome'],
        'httpMethod' => 'post',
        'controller' => '\\Core\\Controllers:testController:someMethod'
    ]
];
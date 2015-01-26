<?php

// TODO: add tutorials page

return $common = [

    'author' => [
        'name' => 'Shalom Sam',
        'email' => 'shalom.s [at] coreframework.in',
        'url' => 'https://github.com/shalomsam'
    ],
    'product' => [
        'name' => 'Core Framework',
        'current_ver' => 'v2.0.0-beta',
        'doc_ver' => '2.0.0',
        'created_on' => '2014-09-12',
        'url' => 'http://www.coreframework.in'
    ],
    'navs' => [
        'Home' => '/',
        'About' => '/about',
        'Get Started' => '/get_started',
        //'Tutorials' => '/tutorials',
        'Documentation' => [
            'link' => '/documentation',
            'Routing' => '/documentation/routing',
            'Controllers' => '/documentation/controllers',
            'View' => '/documentation/view',
            'Templates' => '/documentation/templates',
            'API Reference' => '/documentation/api'
        ],
        'Download' => '/download'
    ]

];
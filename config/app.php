<?php

return [

    /*
     * When set to true ensures that all errors are displayed, based on the 'error_reporting_type' value
     * This is used to explicitly turn error reporting on even when current environment is in Development mode
     */
    'debug' => true,

    /*
     * Determines the error reporting level
     */
    'error_reporting_type' => E_ALL,

    /*
     * Whether to load meta tag info (like keywords and description) and page title
     * from APP_PATH/metas/metas.php
     *
     * Default: false
     */
    'metaAndTitleFromFile' => false,

    /*
     * File containing metas (titles and descriptions).
     * Must be set if 'metaAndTitleFromFile' is set true
     *
     * ex:
     * [
     *      '/' => [
     *           'pageTitle' => 'Some page title',
     *           'description' => 'Some descriptions',
     *           'keyword' => 'some, keywords',
     *           .....
     *       ]
     * ]
     */
    //'metaFile' => '',

    /*
     * Whether the APC caching extension is loaded
     */
    'apcIsLoaded' => extension_loaded('apc'),

    /*
     * Whether APC Caching extension is enabled in php(.ini)
     */
    'apcIsEnabled' => ini_get('apc.enabled'),

    /*
     * Determines whether to use apc caching. Set False to disable.
     *
     * Default: true
     */
    'useAPC' => true,

    /*
     * Determines the website protocol (http || https)
     */
    'httpProtocol' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://",

    /*
     * Determines the domain name (w/o the protocol)
     */
    'domain' => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '',

    /*
     * Determines the website Url (complete Domain Name)
     */
    'domainName' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://" . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ''),

    /*
     * The template engine name (must be the same Key name as given in services)
     */
    'templateEngine' => 'Smarty',

    /*
     * Array containing all Subscriber classes (must implement interface Subscriber)
     */
    'subscribers' => [],

    /*
     * Applications Time To Live (ttl) settings in seconds
     */
    'ttl' => 60,

    /*
     * Path to file containing application route definitions
     */
    //'routesFilePath' => '',

    /*
     * The cache directory path
     */
    'cachePath' => '/storage/framework/cache',

    /*
     * The storage directory path
     */
    'storagePath' => '/storage',

    /*
     * The web document root folder
     */
    'publicPath' => '/web',

];
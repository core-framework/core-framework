<?php

return [

    /*
     * File Path to the routes file containing the route definitions
     */
    'routesFilePath' => '/app/Routes/routes.php',

    /*
     * Array of File Paths to the route files containing the route definitions
     */
    'routesFiles' => [],

    /*
     * Determines whether to ignore routes config and use Aesthetic routing.
     * i.e. www.domain.name/controller/method/argument1/argument2....
     * Arguments will be available as a payload (index) array
     *
     * Default: false
     */
    'useAestheticRouting' => false,

    /*
     * Determines whether to sanitize the Request (object) globals like $_POST,
     * $_GET, etc.
     *
     * Default: true
     */
    'sanitizeGlobals' => true,

    /*
     * Controller configurations
     */
    'controller' => [
        'namespace' => '\\app\\Controllers'
    ]
];
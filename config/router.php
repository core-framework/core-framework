<?php

return [
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
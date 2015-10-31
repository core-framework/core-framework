<?php

return [

    /*
     * When Application Environment(app_env) is set Development State(dev) the application ensure the display
     * of all errors
     *
     * Supported values: 'prod' (Production) & 'dev' (Development)
     * Default: dev
     */
    'app_env' => 'dev',

    /*
     * When set to true ensures that all errors are displayed, based on the 'error_reporting_type' value
     * This is used to explicitly turn error reporting on even when current environment is in Development mode
     */
    'debug' => true,

    /*
     * Determines the error reporting level
     */
    'error_reporting_type' => E_ALL
];
<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$global = [

    /*
     * Whether to load meta tag info (like keywords and description) and page title
     * from APP_PATH/metas/metas.php
     *
     * Default: false
     */
    'metaAndTitleFromFile' => false,

    /*
     * Base App path on system
     */
    'appPath' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'web'),

    /*
     * Base project path on system
     */
    'basePath' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),

    /*
     * Whether the APC caching extension is loaded
     */
    'apcIsLoaded' => extension_loaded('apc'),

    /*
     * Whether APC Caching extension is enabled in php(.ini)
     */
    'apcIsEnabled' => ini_get('apc.enabled'),

    /*
     * Template type determines whether smarty is loaded as current Templating engine or not.
     * use False if you want to disable smarty
     *
     * Default: 'tpl'
     */
    'tplType' => 'tpl',

    /*
     * Determines whether to use apc caching. Set False to disable.
     *
     * Default: true
     */
    'useAPC' => true,

    /*
     * Determines whether to ignore routes config and use Aesthetic routing.
     * i.e. www.domain.name/controller/method/argument1/argument2....
     * Arguments will be available as a payload (index) array
     *
     * Default: false
     */
    'useAestheticRouting' => false,

];

return $global;
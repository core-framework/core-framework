<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//global $_CONFIG;

$global = [

    '$global' => [
        'metaAndTitleFromFile' => false,
        'appPath' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'),
        'basePath' => realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..'),
        'apcIsLoaded' => extension_loaded('apc'),
        'apcIsEnabled' => ini_get('apc.enabled'),
        'tplType' => 'tpl',
        'useAPC' => true,
        'useAestheticRouting' => false,
        'language' => 'en_us',
        'google-site-verification' => ''
    ],
    '$db' => require('db.conf.php'),
    '$routes' => require('routes.conf.php')

];

if ($global['$global']['apcIsLoaded'] && $global['$global']['apcIsEnabled']) {
    $global['$global']['hasAPC'] = true;
} else {
    $global['$global']['hasAPC'] = false;
}

return $global;
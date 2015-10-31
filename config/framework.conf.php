<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$all = [
    '$global' => require('global.conf.php'),
    '$db' => require('db.conf.php'),
    '$routes' => require('routes.conf.php'),
    '$env' => require('env.conf.php'),
    '$components' => require('components.conf.php'),
];

if ($all['$global']['apcIsLoaded'] && $all['$global']['apcIsEnabled']) {
    $all['$global']['hasAPC'] = true;
} else {
    $all['$global']['hasAPC'] = false;
}

$override = require("override.conf.php");

$all = array_replace_recursive($all, $override);

return $all;
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
        'metaAndTitleFromFile' => false
    ],
    '$db' => require('db.conf.php'),
    '$routes' => require('routes.conf.php')

];

return $global;
<?php

$components = [

    'Config' => \Core\Config\AppConfig::class,

    'Cache' => \Core\CacheSystem\OPCache::class,
];

return $components;
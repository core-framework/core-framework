<?php

return [

    'default' => 'mysql',

    'connections' => [
        'mysql' => [
            'mapper' => \Core\Database\Mapper\MySqlMapper::class,
            'type' => 'mysql',
            'db' => 'coreframework_db',
            'host' => '127.0.0.1',
            'user' => 'root',
            'pass' => '',
            'options' => []
        ]
    ]

];
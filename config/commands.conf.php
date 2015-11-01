<?php

$commands = [
    //Test command definition
    0 => [
        'name' => 'hello:world',
        'description' => 'Simple Hello World Command',
        'definition' => '\\Core\\Console\\CLI::helloWorld',
        'arguments' => [
            'name' => 'name',
            'isRequired' => false,
            'description' => 'Your Name'
        ]
    ],
];

return $commands;
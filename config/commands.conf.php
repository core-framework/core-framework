<?php

$commands = [
    //Test command definition
    0 => [
        'name' => 'hello:world',
        'description' => 'Simple Hello World Command',
        'definition' => function ($name) {
            $name = isset($name) && $name !== "" ? $name : "world";
            return "hello " . $name;
        },
        'arguments' => [
            'name' => 'name',
            'isRequired' => false,
            'description' => 'Your Name'
        ]
    ],
];

return $commands;
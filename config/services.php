<?php

return [
    'View' => [
        \Core\View\View::class,
        ['App']
    ],
    'Smarty' => \Core\View\SmartyEngine::class,
    'Session' => \Core\Session\Session::class,
    'Password' => \Core\Auth\Hasher\BCrypt::class
];
<?php
return [
    'module_init'  => [
        'app\\console\\behavior\\ModuleInit',
    ],
    'action_begin' => [
        'app\\console\\behavior\\CheckLogin',
        'app\\console\\behavior\\CheckAuth',
    ],

    'app_end'      => [

    ],

    'action_log'   => [
        'app\\console\\behavior\\ActionLog',
    ],
];

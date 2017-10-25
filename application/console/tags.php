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
        'app\\console\\behavior\\ActionLog',
    ],
];

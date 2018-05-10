<?php

return [
    'role_structure' => [
        'administrator' => [
            'users' => 'c,r,u,d',
            'performance' => 'c,r,u,d',
            'seances' => 'c,r,u,d',
            'employees' => 'c,r,u,d',
            'positions' => 'c,r,u,d',
            'stages' => 'c,r,u,d',
            'units' => 'c,r,u,d',
            'category_places' => 'c,r,u,d',
            'seasons' => 'c,r,u,d',
            'tickets' => 'c,r,u,d',   
        ],
        'moderator' => [
            'users' => 'r',
            'performance' => 'c,r,u,d',
            'seances' => 'c,r,u,d',
            'employees' => 'c,r,u,d',
            'positions' => 'c,r,u,d',
            'stages' => 'c,r,u,d',
            'units' => 'c,r,u,d',
            'category_places' => 'c,r,u,d',
            'seasons' => 'c,r,u,d',
            'tickets' => 'c,r,u,d',
        ],
        'user' => [
            'tickets' => 'r'
        ],
    ],
    'permission_structure' => [
        // 'cru_user' => [
        //     'profile' => 'c,r,u'
        // ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ]
];

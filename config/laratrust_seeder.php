<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'superadmin' => [
            'users' => 'c,r,u,d',
            'provinces' => 'c,r,u,d',
            'supervisors' => 'c,r,u,d',
            'schools' => 'c,r,u,d',
            'students' => 'c,r,u,d',
            'programs' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'gifted_manager' => [
            'users' => 'c,r,u,d',
            'provinces' => 'c,r,u,d',
            'supervisors' => 'c,r,u,d',
            'schools' => 'c,r,u,d',
            'students' => 'c,r,u,d',
            'programs' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'supervisor' => [
            'schools' => 'c,r,u,d',
            'students' => 'c,r,u,d',
            'programs' => 'c,r,u,d',
            'profile' => 'r,u',
        ],
        'school_manager' => [
            'students' => 'r,u',
            'profile' => 'r,u',
        ],
        'teacher' => [
            'schools' => 'r',
            'students' => 'r,u',
            'profile' => 'r,u',
        ],
        'student' => [
            'programs' => 'r',
            'profile' => 'r,u',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];

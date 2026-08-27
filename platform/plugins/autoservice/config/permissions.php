<?php

return [
    [
        'name' => 'Autoservices',
        'flag' => 'autoservice.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'autoservice.create',
        'parent_flag' => 'autoservice.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'autoservice.edit',
        'parent_flag' => 'autoservice.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'autoservice.destroy',
        'parent_flag' => 'autoservice.index',
    ],
];

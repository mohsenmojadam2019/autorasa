<?php

return [
    [
        'name' => 'Shetabits',
        'flag' => 'shetabit.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'shetabit.create',
        'parent_flag' => 'shetabit.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'shetabit.edit',
        'parent_flag' => 'shetabit.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'shetabit.destroy',
        'parent_flag' => 'shetabit.index',
    ],
];

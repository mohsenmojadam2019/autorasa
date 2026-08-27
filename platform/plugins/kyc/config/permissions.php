<?php

return [
    [
        'name' => 'Kyc',
        'flag' => 'plugin.kyc',
    ],
    [
        'name' => 'Kyc',
        'flag' => 'kyc.index',
        'parent_flag' => 'plugin.kyc',
    ],
    [
        'name' => 'Create',
        'flag' => 'kyc.create',
        'parent_flag' => 'kyc.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'kyc.edit',
        'parent_flag' => 'kyc.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'kyc.destroy',
        'parent_flag' => 'kyc.index',
    ],
    [
        'name' => 'Show',
        'flag' => 'kyc.show',
        'parent_flag' => 'kyc.index',
    ],
    [
        'name' => 'List',
        'flag' => 'kyc.list',
        'parent_flag' => 'kyc.index',
    ],
    [
        'name' => 'Kyc Group Fields',
        'flag' => 'kyc-group-fields.index',
        'parent_flag' => 'plugin.kyc',
    ],
    [
        'name' => 'Create',
        'flag' => 'kyc-group-fields.create',
        'parent_flag' => 'kyc-group-fields.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'kyc-group-fields.edit',
        'parent_flag' => 'kyc-group-fields.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'kyc-group-fields.destroy',
        'parent_flag' => 'kyc-group-fields.index',
    ],
    [
        'name' => 'Kyc Fields',
        'flag' => 'kyc-fields.index',
        'parent_flag' => 'plugin.kyc',
    ],
    [
        'name' => 'Create',
        'flag' => 'kyc-fields.create',
        'parent_flag' => 'kyc-fields.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'kyc-fields.edit',
        'parent_flag' => 'kyc-fields.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'kyc-fields.destroy',
        'parent_flag' => 'kyc-fields.index',
    ],
    [
        'name' => 'Kyc Submissions',
        'flag' => 'submissions.index',
        'parent_flag' => 'plugin.kyc',
    ],
    [
        'name' => 'Create',
        'flag' => 'submissions.create',
        'parent_flag' => 'submissions.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'submissions.edit',
        'parent_flag' => 'submissions.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'submissions.destroy',
        'parent_flag' => 'submissions.index',
    ],
    [
        'name' => 'Approve',
        'flag' => 'submissions.approve',
        'parent_flag' => 'submissions.index',
    ],
    [
        'name' => 'Reject',
        'flag' => 'submissions.reject',
        'parent_flag' => 'submissions.index',
    ],
    [
        'name' => 'Kyc Pending Submissions',
        'flag' => 'pendingsubmissions.index',
        'parent_flag' => 'plugin.kyc',
    ],
    [
        'name' => 'Create',
        'flag' => 'pendingsubmissions.create',
        'parent_flag' => 'pendingsubmissions.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'pendingsubmissions.edit',
        'parent_flag' => 'pendingsubmissions.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'pendingsubmissions.destroy',
        'parent_flag' => 'pendingsubmissions.index',
    ],
];

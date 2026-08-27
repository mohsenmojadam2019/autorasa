<?php

return [
    [
        'name' => 'Campaign',
        'flag' => 'plugin.campaign',
    ],
    [
        'name' => 'Campaigns',
        'flag' => 'campaign.index',
        'parent_flag' => 'plugin.campaign',
    ],
    [
        'name' => 'Create',
        'flag' => 'campaign.create',
        'parent_flag' => 'campaign.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'campaign.edit',
        'parent_flag' => 'campaign.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'campaign.destroy',
        'parent_flag' => 'campaign.index',
    ],
    [
        'name' => 'Operators',
        'flag' => 'operators.index',
        'parent_flag' => 'plugin.campaign',
    ],
    [
        'name' => 'Create',
        'flag' => 'operators.create',
        'parent_flag' => 'operators.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'operators.edit',
        'parent_flag' => 'operators.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'operators.destroy',
        'parent_flag' => 'operators.index',
    ],
    [
        'name' => 'campaignsubmissions',
        'flag' => 'campaignsubmissions.index',
        'parent_flag' => 'plugin.campaign',
    ],
//    [
//        'name' => 'Create',
//        'flag' => 'submissions.create',
//        'parent_flag' => 'submissions.index',
//    ],
    [
        'name' => 'Edit',
        'flag' => 'campaignsubmissions.edit',
        'parent_flag' => 'campaignsubmissions.index',
    ],
//    [
//        'name' => 'Delete',
//        'flag' => 'submissions.destroy',
//        'parent_flag' => 'submissions.index',
//    ],
];

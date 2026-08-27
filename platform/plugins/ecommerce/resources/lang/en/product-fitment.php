<?php

return [
    'product_fitment' => 'Product Fitment',
    'fitment_groups' => [
        'title' => 'Fitment Groups',

        'create' => [
            'title' => 'Create Fitment Group',
        ],

        'edit' => [
            'title' => 'Edit Fitment Group ":name"',
        ],
    ],

    'fitment_attributes' => [
        'title' => 'Fitment Attributes',
        'type_placeholder'=>'Type',
        'parent'=>'Parent',
        'group' => 'Associated Group',
        'group_placeholder' => 'Choose any Group',
        'parent_placeholder' => 'Choose any Parent',
        'type' => 'Field Type',
        'default_value' => 'Default Value',
        'options' => [
            'heading' => 'Options',
            'parent'=>'Parent',
            'add' => [
                'label' => 'Add new option',
            ],
        ],
        'svgicon'=>'SVG Icon',
        'create' => [
            'title' => 'Create Fitment Attribute',
        ],

        'edit' => [
            'title' => 'Edit Fitment Attribute ":name"',
        ],
    ],

    'fitment_tables' => [
        'title' => 'Fitment Tables',

        'create' => [
            'title' => 'Create Fitment Table',
        ],

        'edit' => [
            'title' => 'Edit Fitment Table ":name"',
        ],

        'fields' => [
            'groups' => 'Select the groups to display in this table',
            'name' => 'Group name',
            'assigned_groups' => 'Assigned Groups',
            'sorting' => 'Sorting',
        ],
    ],
    'fitment_products'=>[
        'title'=>'Fitment Product',
        'edit'=>[
            'title'=>'Edit'
        ],
        'create'=>[
            'title'=>'Create'
        ]
    ],
    'product' => [
        'fitment_table' => [
            'options' => 'Options',
            'title' => 'Fitment Table',
            'select_none' => 'None',
            'description' => 'Select the fitment table to display in this product',
            'group' => 'Group',
            'attribute' => 'Attribute',
            'value' => 'Attribute value',
            'hide' => 'Hide',
            'sorting' => 'Sorting',
            'show_in_detail' => 'show In Detail',
            'show_in_card' => 'Show In Card',
            'no_parent'=>'Without Parent',
            'parent'=>'Parent'

        ],
    ],

    'enums' => [
        'field_types' => [
            'text' => 'Text',
            'textarea' => 'Textarea',
            'select' => 'Select',
            'checkbox' => 'Checkbox',
            'radio' => 'Radio',
        ],
    ],
];

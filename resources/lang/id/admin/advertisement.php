<?php

return [
    'messages' => [
        'success' => 'Create advertisement successfully.',
        'delete_success' => 'Delete advertisement successfully.',
        'fail' => 'Expired to wrong',
        'delete_fail' => 'Something went wrong',
    ],
    'button' => [
        'create' => 'Create',
        'no' => 'No',
        'remove' => 'Remove',
    ],
    'label' => [
        'update' => 'Update Advertisement',
        'list' => 'List Advertisement',
        'from_to' => 'Period',
        'from' => 'From',
        'to' => 'To',
        'upload' => 'Upload',
        'url' => 'Url',
        'publish' => 'Publish',
        'unpublish' => 'Unpublish',
        'in_future' => 'Update Time',
        'note' => 'Enter Url to publish Advertisement',
    ],
    'label_yes' => 'Yes',
    'label_no' => 'No',
    'label_delete_question' => 'Are you sure to delete token ?',
    'label_delete_question_title' => 'Delete token',
    'label_title' => 'Advertisement Setting',
    'add_title' => 'Add Advertisement',
    'list_title' => 'List Advertisement',
    'validate' => [
        'after_end_date' => 'The End Date time must be a date after the Start time and Current time',
        'after_start_date' => 'The Start Date time must be a date after Current time',
        'active_url' => 'The Url is not a valid URL.',
        'require' => [
            'end_date' => 'The End Date field is required.',
            'start_date' => 'The Start Date field is required.',
            'url' => 'The Url field is required.',
            'photo' => 'The Photo field is required.',
        ],
        'max' => [
            'url' => 'The Url may not be greater than :max characters.',
        ],
    ]
];

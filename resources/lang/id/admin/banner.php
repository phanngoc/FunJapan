<?php

return [
    'title' => 'Banner setting',
    'image_suggest_sie' => 'Standard dimention: 1000*400',
    'validate' => [
        'file_type' => 'The photo must be a file of type: jpeg, png, jpg!',
        'unauthorized' => 'The request has not been applied because it lacks valid authentication credentials for the target resource!',
        'duplicate' => 'The article duplicate!',
        'not_show' => 'The article not setup for show in front!',
        'required' => [
            'article_locale_id' => 'Please, select a article!',
            'photo' => 'Please, upload image!',
        ],
    ],
    'label_update_success' => 'Banner has been update successfully!',
    'label_update' => 'Update',
    'label_update_all' => 'Update',
    'label_delete_all' => 'Clear',
    'label_upload' => 'Upload',
    'label_title' => 'Title',
    'label_summary' => 'Summary',
    'label_banner' => 'Banner Setting',
    'search_by' => 'Search by title of article',
    'label_delete_success' => 'Banner has been delete successfully!',
    'label_yes' => 'Yes',
    'label_no' => 'No',
    'label_delete_question' => 'Are you sure to delete banner ?',
    'label_delete_question_title' => 'Delete Banner',
];

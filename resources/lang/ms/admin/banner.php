<?php

return [
    'title' => 'Add Banner',
    'title_list' => 'Banner List',
    'note' => ' If you doesn\'t setting article , photo will be empty',
    'image_suggest_size' => 'Standard dimention of thumbnail: 1000*400',
    'condition_show_in_front' => 'Mandatory set 3 banners and status of banners must be active to show in front',
    'status' => 'Status',
    'active' => 'Active',
    'deactive' => 'Deactive',
    'validate' => [
        'file_type' => 'The photo must be a file of type: jpeg, png, jpg!',
        'unauthorized' => 'The request has not been applied because it lacks valid authentication credentials for the target resource!',
        'duplicate' => 'The article duplicate!',
        'not_show' => 'The article not setup for show in front!',
        'required' => [
            'article_locale_id' => 'Please, select a article!',
            'photo' => 'Please, upload image!',
        ],
        'from.before' => '',
        'to.before' => 'The End time must be a date after the Start time',
    ],
    'label_update_success' => 'Banner has been updated successfully!',
    'label_update' => 'Update',
    //'label_delete_all' => 'Delete',
    'label_upload' => 'Upload',
    'label_title' => 'Title',
    'label_summary' => 'Summary',
    'label_banner' => 'Banner Setting',
    'search_by' => 'Search by title of article',
    //'label_delete_success' => 'Banner has been deleted successfully!',
    'label_yes' => 'Yes',
    'label_no' => 'No',
    //'label_delete_question' => 'Are you sure to delete banner ?',
    //'label_delete_question_title' => 'Delete Banner',
    'label_change_locale_title' => 'Change location',
    'label_change_locale_question' => 'Change location will be reset article choice. Are you sure ?',
    'label_from_to' => 'From - To',
    'label_locale' => 'Country',
    'label_place' => 'Place',
    'label_article' => 'Article',
    'label_edit' => 'Edit',
    'label_stop_edit' => 'Stop Edit',
    'change_mode_edit_title' => 'Switch To Edit Mode',
    'change_mode_edit_question' => 'Switch To Edit Mode will be reset article choice. Are you sure ?',
    'change_mode_add_title' => 'Switch To Add Mode',
    'change_mode_add_question' => 'Switch To Add Mode will be reset article choice. Are you sure ?',
    'order' => [
        'top' => 'Top',
        'middle' => 'Middle',
        'bottom' => 'Bottom',
    ],
    'label_replace_question' => 'Are you sure to replace banner ?',
    'label_replace_question_title' => 'Replace Banner',
    'setting_management' => 'Setting Management',
];

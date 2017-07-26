<?php

return [
    'no' => 'No',
    'title' => 'Title',
    'language' => 'Language',
    'created_at' => 'Created at',
    'detail' => 'Detail',
    'article_management' => 'Article Management',
    'article_list' => 'Article List',
    'add_article' => 'Add Article',
    'edit_article' => 'Edit Article',
    'list_language' => 'Article detail',
    'list_article' => 'Article List',
    'list_tag' => 'List Article Tags',
    'category' => 'Article Category',
    'thumbnail' => 'Article Thumbnail',
    'published_at' => 'Hide Until',
    'action' => 'Action',
    'create_success' => 'Created Successfully',
    'create_error' => 'Created Error',
    'update_success' => 'Updated Successfully',
    'update_error' => 'Updated Error',
    'delete_success' => 'Deleted Successfully',
    'delete_error' => 'Deleted Error',
    'add_error' => 'Add Error',
    'add_success' => 'Add Success',
    'locale_not_exist' => 'Locale Not Exist',
    'list_article_of_tag' => 'List Article Of Tag: ',
    'select_category' => 'Select Category',
    'edit_global' => 'Edit general informations',
    'title_global' => 'General informations',
    'hide_alway' => 'Always Hide',
    'is_member_only' => 'Only For Member',
    'is_top_article' => 'Always On Top',
    'button' => [
        'create' => 'Create',
        'set_language' => 'Set Other Language',
        'edit' => 'Edit',
        'lang_edit' => 'Edit :lang Article',
        'add' => 'Add',
        'update' => 'Update',
        'cancel' => 'Cancel',
        'delete' => 'Delete',
        'create_new' => 'Create New',
        'clone' => 'Clone First Tab',
        'stop' => 'Stop',
        'filter' => 'Filter',
        'yes' => 'Yes',
        'use_medium' => 'Using Medium Editor',
        'use_markdown' => 'Using Markdown Editor',
        'draft' => 'Draft',
        'check_preview' => 'Check Preview',
        'no' => 'No',
        'next' => 'Next',
        'mobile_preview' => 'Mobile Preview',
        'pc_preview' => 'PC Preview',
        'thumbnail_preview' => 'Thumbnail Preview',
        'color_panel' => 'Color Panel',
        'back' => 'Back',
        'null' => 'Null',
        'start' => 'Start',
        'modify' => 'Modify',
        'ok' => 'OK',
    ],
    'messages' => [
        'confirm_title' => 'Article ID #:id',
        'confirm_stop' => 'Are you sure to stop ',
        'stop_success' => 'The articles belong to all locales were stopped.',
        'stop_error' => 'Can not stop the articles.',
        'not_supported_format' => 'This file is not in a supported format (jpeg, png, jpg): ',
        'max_size_error' => 'This file is too big (not greater than ' . config('images.validate.article_content.max_size') / 1024 . 'MB): ',
        'no_images' => 'No Images',
        'published_date_format' => 'Published Date Time Format is not correct.',
        'end_published_date_format' => 'End Published Date Time Format is not correct.',
        'published_date_required' => 'Published Date is required.',
        'end_published_date_required' => 'End Published Date is required.',
        'end_published_date_after' => 'End Published Date must be after Published Date.',
        'category_required' => 'Category is required.',
        'sub_category_required' => 'Sub Category is required.',
        'author_required' => 'Author is required.',
        'locale_required' => 'Country is required',
        'warning_change_data' => 'Articles on another locales will be changed.',
        'start_confirm' => 'Do you want to start this article?',
        'stop_confirm' => 'Do you want to stop this articles?',
        'some_thing_wrong' => 'Some thing went wrong.',
        'article_locale_start_success' => 'This article was started successfully',
        'article_locale_start_error' => 'Please edit start published date and end published date then start this article',
        'article_locale_stop_success' => 'This article was stopped successfully',
        'article_locale_stop_error' => 'This article was not stopped',
    ],
    'label' => [
        'is_top' => 'Always On Top?',
        'title' => 'Article Title',
        'content' => 'Article Content',
        'locale' => 'Language',
        'category' => 'Category',
        'publish_date' => 'Published time',
        'tags' => 'Tags',
        'summary' => 'Summary',
        'thumbnail' => 'Thumbnail',
        'type' => 'Type',
        'auto_approve_photo' => 'Auto Approve Photo',
        'yes' => 'Yes',
        'no' => 'No',
        'time_campaign' => 'Campaign Time',
        'start_campaign' => 'Campaign start at',
        'end_campaign' => 'Campaign end at',
        'is_alway_hide' => 'Always Hide',
        'is_member_only' => 'Only For Member',
        'comment_limit' => 'Comment Limit Per User',
        'tags.*' => 'Tags',
        'current_thumbnail' => 'Current Thumbnail',
        'article_id' => 'Article ID',
        'published_at' => 'Published Date',
        'country' => 'Country',
        'action' => 'Action',
        'search' => 'Search',
        'showing' => 'Showing',
        'items' => 'Items',
        'no_article' => 'No Articles',
        'client_id' => 'Client ID',
        'home' => 'Home',
        'article' => 'Article',
        'list' => 'list',
        'author' => 'Author',
        'choose_client_id' => 'Choose Client ID',
        'choose_country' => 'Choose Country',
        'published_time' => 'Time (JST)',
        'end_publish_date' => 'End Published time',
        'end_publish_time' => 'Time (JST)',
        'choose_category' => 'Choose Category',
        'choose_sub_category' => 'Sub Category',
        'hide' => 'Hide',
        'member_only' => 'Member Only',
        'description' => 'Meta Description',
        'create' => 'Create',
        'preview' => 'Preview',
        'confirmation' => 'Confirmation',
        'article_create' => 'Article Create',
        'article_edit' => 'Article Edit',
        'article_preview_mobile' => 'Article Preview (Mobile)',
        'article_preview_pc' => 'Article Preview (PC)',
        'article_preview_thumbnail' => 'Thumbnail Preview',
        'article_confirm' => 'Confirmation',
        'new' => 'New',
        'new_article' => 'New Article',
        'total' => 'Total',
        'none' => 'None',
        'edit' => 'Edit',
        'select_author' => '---- Select Author ----',
        'select_client' => '---- Select Client ----',
        'select_category' => '---- Select Category ----',
        'select_locale' => '---- Select Locale ----',
        'select_sub_category' => '---- Select Sub Category ----',
        'other_management' => 'Other Article Management',
    ],
    'status_by_locale' => [
        'schedule' => 'Schedule',
        'stop' => 'Stop',
        'published' => 'Published',
        'no_article' => 'Null',
        'draft' => 'Draft',
    ],
    'type' => [
        'normal' => 'Normal Article',
        'photo' => 'Photo Article',
        'campaign' => 'Campaign Article',
        'coupon' => 'Coupon Article',
        'location' => 'Location Article',
    ],
    'placeholder' => [
        'title' => 'Input Title',
        'content' => 'Input Content',
        'locale' => 'Locale',
        'category' => 'Category',
        'start_time' => 'Start Time',
        'end_time' => 'End Time',
        'published_at' => 'Published Time',
    ],
    'set_language' => 'Set language of Article',
    'author' => 'Author',
    'article_type' => 'Article Type',
    'cancel_message' => 'Are you sure you want to cancel?',
    'mimes_message' => 'The photo must be a file of type: jpeg,png,jpg!',
    'size_message' => 'The photo size must not greater than 10MB',
    'always_on_top' => [
        'validate' => [
            'after_end_date' => 'The End date must be a date after the Start date and Current date.',
            'after_start_date' => 'The Start date must be a date after the Current date.',
        ],
        'label_title_menu' => 'Always on top',
        'label_yes' => 'Yes',
        'label_no' => 'No',
        'label_article' => 'Article',
        'label_country' => 'Country',
        'title' => 'Add always on top',
        'title_list' => 'List always on top',
        'label_delete_question' => 'The locale has established article. Do you want to change?',
        'label_delete_question_title' => 'Remove always on top',
        'label_change_locale_title' => 'Change location',
        'label_change_locale_question' => 'The Article field will be reset when changing location. Are you sure?',
        'label_delete_success' => 'Removed always on top successfully!',
        'label_update_success' => 'Add always on top successfully!',
        'label_update' => 'Add',
        'label_delete' => 'Delete',
        'label_title' => 'Title',
        'label_summary' => 'Summary',
        'label_update_question_title' => 'The locale has established article.Do you want to change?',
        'label_update_title' => 'Update setting always on top',
        'label_from' => 'From',
        'label_from_to' => 'From - To',
        'label_to' => 'To',
        'status' => 'Status',
        'deactive' => 'Deactive',
        'active' => 'Active',
    ],
];

<?php

return [
    'paths' => [
        'post_photo' => 'uploads/articles/post_photos',
        'category_icon' => 'uploads/categories/icons/',
    ],
    'validate' => [
        'post_photo' => [
            'mimes' => 'jpeg,png,jpg',
            'max_size' => 10240,
        ],
        'category_icon' => [
            'mimes' => 'jpeg,png,jpg',
        ],
    ],
    'accept_extension' => '.jpeg,.png,.jpg',
    'default' => [
        'post_photo' => '',
    ],
    'dimensions' => [
        'post_photo' => [
            'original' => '',
            'thumbnail' => [640, 640],
        ],
        'category_icon' => [
            'normal' => [32, 32],
        ],
    ],
    'not_resize' => [
    ],
];

<?php

return [
    'paths' => [
        'post_photo' => 'uploads/articles/post_photos',
        'category_icon' => 'uploads/categories/icons/',
        'article_thumbnail' => 'uploads/articles/thumbnail',
    ],
    'validate' => [
        'post_photo' => [
            'mimes' => 'jpeg,png,jpg',
            'max_size' => 10240,
        ],
        'category_icon' => [
            'mimes' => 'jpeg,png,jpg',
        ],
        'article_thumbnail' => [
            'max_size' => 10240,
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
        'article_thumbnail' => [
            'original' => '',
            'larger' => [850, 450],
            'normal' => [400, 200],
            'small' => [96, 60],
        ],
    ],
    'not_resize' => [
    ],
];

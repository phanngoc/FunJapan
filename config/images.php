<?php

return [
    'paths' => [
        'post_photo' => 'uploads/articles/post_photos',
    ],
    'validate' => [
        'post_photo' => [
            'mimes' => 'jpeg,png,jpg',
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
    ],
    'not_resize' => [
    ],
];

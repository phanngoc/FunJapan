<?php

return [
    'paths' => [
        'post_photo' => 'uploads/articles/post_photos',
        'category_icon' => 'uploads/categories/icons',
        'article_thumbnail' => 'uploads/articles/thumbnail',
        'banner' => 'uploads/banner',
        'menu_icon' => 'uploads/menu',
        'omikuji_image' => 'uploads/omikujis/image',
        'omikuji_item_image' => 'uploads/omikujis/omikuji_items/image',
        'popular_series_image' => 'uploads/popular_series',
    ],
    'validate' => [
        'post_photo' => [
            'mimes' => 'jpeg,png,jpg',
            'max_size' => 10240,
        ],
        'category_icon' => [
            'mimes' => 'jpeg,png,jpg',
            'max_size' => 10240,
        ],
        'article_thumbnail' => [
            'max_size' => 10240,
        ],
        'banner' => [
            'mimes' => 'jpeg,png,jpg',
            'max_size' => 10240,
        ],
        'menu_icon' => [
            'max_size' => 10240
        ],
        'omikuji_image' => [
            'mimes' => 'jpeg,png,jpg',
            'max_size' => 10240,
        ],
        'omikuji_item_image' => [
            'mimes' => 'jpeg,png,jpg',
            'max_size' => 10240,
        ],
        'popular_series_image' => [
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
            'normal' => [22, 26],
            'larger' => [90, 90],
        ],
        'omikuji_image' => [
            'original' => '',
            'normal' => [200, 200],
            'small' => [32, 32],
        ],
        'omikuji_item_image' => [
            'original' => '',
            'normal' => [200, 200],
            'small' => [32, 32],
        ],
        'article_thumbnail' => [
            'original' => '',
            'larger' => [850, 450],
            'normal' => [400, 200],
            'small' => [96, 60],
        ],
        'banner' => [
            'original' => '',
            'larger' => [1000, 400],
            'small' => [200, 129],
        ],
        'menu_icon' => [
            'normal' => [20, 20],
            'larger' => [96, 60],
        ],
        'popular_series_image' => [
            'normal' => [180, 90],
            'small' => [32, 32],
        ],
    ],
    'not_resize' => [
    ],
];

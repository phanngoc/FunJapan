<?php

return [
    'thumbnail' => [
        'upload' => [
            'max_size' => 1000,
            'upload_path' => 'upload/articles/',
            'demensions' => [
                'original_' => [
                    'width' => 850,
                    'height' => 450,
                ],
                'larger_' => [
                    'width' => 850,
                    'height' => 450,
                ],
                'normal_' => [
                    'width' => 400,
                    'height' => 200,
                ],
                'small_' => [
                    'width' => 96,
                    'height' => 60,
                ],
            ],
        ],
    ],
    'relate_article' => [
        'same_category' => 3,
        'same_tag' => 3,
        'random' => 2,
    ],

    'type' => [
        'normal' => 0,
        'photo' => 1,
    ],

    'limit_short_title' => 37,
    'limit_short_summary' => 80,
    'rank' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
    'per_page' => 10,
    'rank_1' => 1,
];

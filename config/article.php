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
                    'width' => 200,
                    'height' => 100,
                ],
            ],
        ],
    ],
    'relate_article' => [
        'same_category' => 3,
        'same_tag' => 3,
        'random' => 2,
    ]
];

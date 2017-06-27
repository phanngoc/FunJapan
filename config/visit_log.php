<?php

return [
    'relate_type' => [
        'tag' => 1,
        'article' => 2,
    ],
    'hot_key' => [
        'limit' => [
            'tag' => 30,
            'article' => 6,
        ],
        'cache_key' => [
            'tag' => 'cache_hot_tag',
            'article' => 'cache_hot_article',
        ],
    ],
];

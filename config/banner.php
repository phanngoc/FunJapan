<?php

return [
    'limit' => 3,
    'article_suggest' => 10,
    //'minimum_input_length' => 3,
    'order' => [
        'top' => 1,
        'middle' => 2,
        'bottom' => 3,
    ],
    'advertisement' => [
        'status' => [
            'unpublic' => 0,
            'public' => 1,
            'in_future' => 2,
        ]
    ]
];

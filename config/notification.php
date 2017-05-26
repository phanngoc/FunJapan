<?php

return [
    'type' => [
        'reply_comment' => 0,
        'like_comment' => 1,
    ],
    'status' => [
        'un_read' => 0,
        'read' => 1,
    ],
    'echo_server_url' => env('ECHO_SERVER_URL', 'http://localhost:6001'),
    'echo_server_enable' => env('ECHO_SERVER_ENABLE', false),
];

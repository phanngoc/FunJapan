<?php

return [
    'placeholder' => [
        'email' => 'Email',
        'password' => 'Password',
    ],
    'button' => [
        'login' => 'Login',
    ],
    'validate' => [
        'required' => [
            'email' => 'Please enter your e-mail address.',
            'password' => 'Please enter the password.',
        ],
        'min' => [
            'password' => 'Password needs to be longer, at least 6 letters.',
        ],
        'max' => [
            'password' => 'Please enter your password in 50 characters or less.',
            'email' => 'Please enter your email address in 100 characters or less.',
        ],
        'email' => 'Use a valid e-mail address.',
    ],
    'login_fail' => 'The e-mail address or the password is wrong.',
    'password_wrong' => 'The password is wrong.',
];

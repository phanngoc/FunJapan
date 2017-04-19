<?php

return [
    'validate' => [
        'required' => [
            'name' => 'Please enter your name.',
            'email' => 'Please enter your e-mail address.',
            'password' => 'Please enter the password.',
            're_password' => 'Please enter the password for confirmation.',
            'gender' => 'Please select your gender.',
            'location_id' => 'Please enter the location where you live, eat and sleep.',
            'birthday' => 'The birthday is non-existent.',
            'accept_policy' => 'Please accept the terms of use and the privacy policy',
        ],
        'min' => [
            'password' => 'Password needs to be longer, at least 6 letters.',
        ],
        'unique' => [
            'email' => 'Your account is already activated.',
        ],
        'not_match' => [
            're_password' => 'The password for confirmation does not match with the password.',
        ],
        'email' => 'Use a valid e-mail address.',
    ],
    'login_fail' => 'The e-mail address or the password is wrong.',
    'password_wrong' => 'The password is wrong.',
    'updated_fail' => 'Updated fail',
];

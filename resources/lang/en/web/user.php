<?php

return [
    'validate' => [
        'required' => [
            'name' => 'Please enter your name.',
            'email' => 'Please enter your e-mail address.',
            'password' => 'Please enter the password.',
            'password_confirmation' => 'Please enter the password for confirmation.',
            'gender' => 'Please select your gender.',
            'location_id' => 'Please enter the location where you live, eat and sleep.',
            'birthday' => 'The birthday is non-existent.',
            'accept_policy' => 'Please accept the terms of use and the privacy policy',
        ],
        'min' => [
            'password' => 'Password needs to be longer, at least 6 letters.',
            'password_confirmation' => 'Password confirmation needs to be longer, at least 6 letters.',
        ],
        'max' => [
            'name' => 'Your name needs to be shorter, at most 50 letters.',
            'password' => 'Your password needs to be shorter, at most 50 letters.',
            'password_confirmation' => 'Your password confirmation needs to be shorter, at most 50 letters.',
            'email' => 'Your email needs to be shorter, at most 100 letters.',
        ],
        'unique' => [
            'email' => 'Your account is already activated.',
        ],
        'not_match' => [
            're_password' => 'The password for confirmation does not match with the password.',
        ],
        'exists' => [
            'email' => 'Your account is not activated.',
        ],
        'email' => 'Use a valid e-mail address.',
    ],
    'login_fail' => 'The e-mail address or the password is wrong.',
    'password_wrong' => 'The password is wrong.',
    'updated_fail' => 'Updated fail',
    'lost_password' => [
        'title' => 'Lupa Kata Sandi?',
        'title_requested' => 'Terima Kasih!',
        'title_reset_password' => 'Terima Kasih!',
        'description' => 'Silakan masukkan alamat emailmu. Kamu akan menerima link untuk membuat kata sandi baru melalui email.',
        'description_requested' => 'Silakan periksa emailmu untuk konfirmasi link.',
        'description_reset_password' => 'Silahkan masukkan kata sandi barumu.',
        'email_facebook' => "<p>The password of Facebook account cannot be re-set up.</p>When the password of Facebook account has been forgotten, please re-set up a password on Facebook.",
    ],
    'token_not_found' => 'Token is wrong or expired',
    'alert_show_error' => [
        'title' => 'Please, correct the followings errors',
    ],
    'login' => [
        'facebook_login_title' => 'Terhubung ke Fun! Japan dengan akun Facebook.',
        'facebook_login_text' => 'Login with Facebook',
        'or' => 'ATAU',
        'email_login_title' => 'Sign in dengan e mail address',
        'login_title' => 'Login to Fun! Japan',
    ],
    'label' => [
        'name_title' => 'Your Name',
        'email_title' => 'E-Mail Address',
        'gender_title' => 'E-Mail Address',
        'password_title' => 'Password',
        're_password_title' => 'Password, Again',
        're_password_placeholder' => 'Confirm your password',
        'name_placeholder' => 'Enter your name',
        'email_placeholder' => 'Enter your email address',
        'password_placeholder' => 'Minimum 6 letters',
        'login' => 'Login',
        'forgot_password' => 'Lupa kata sandi?',
        'month' => 'Month',
        'day' => 'Day',
        'year' => 'Year',
        'location_title' => 'Location',
        'religion_title' => 'Religion',
        'subscription_title' => 'Subscription',
        'subscription_new_letter' => 'Receive "Newsletter Email"',
        'subscription_reply_noti' => 'Receive "Reply Notification Email"',
        'accept_policy' => 'I accept the terms of use and the privacy policy.',
        'next' => 'Next',
    ],
    'register_page' => [
        'banner' => [
            'step_1_title' => 'Check member benefit',
            'step_2_title' => 'Fill your information',
            'step_3_title' => 'Registration completed',
            'text_country' => 'Japan',
        ],
        'term_title' => 'Terms and Conditions and Privacy policy'
    ],
];

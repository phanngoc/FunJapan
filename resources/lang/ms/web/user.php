<?php

return [
    'validate' => [
        'required' => [
            'name' => 'Please enter your name.',
            'email' => 'Please enter your e-mail address.',
            'password' => 'Please enter the password.',
            'new_password' => 'Please enter the new password.',
            'password_confirmation' => 'Please enter the password for confirmation.',
            'gender' => 'Please select your gender.',
            'location_id' => 'Please enter the location where you live, eat and sleep.',
            'birthday' => 'The birthday is non-existent.',
            'accept_policy' => 'Please accept the terms of use and the privacy policy',
        ],
        'min' => [
            'password' => 'Password needs to be longer, at least 6 letters.',
            'new_password' => 'Password needs to be longer, at least 6 letters.',
            'password_confirmation' => 'Password confirmation needs to be longer, at least 6 letters.',
        ],
        'max' => [
            'name' => 'Please enter your name in 50 characters or less.',
            'password' => 'Please enter your password in 50 characters or less.',
            'new_password' => 'Please enter your new password in 50 characters or less.',
            'password_confirmation' => 'Please enter your password confirmation in 50 characters or less.',
            'email' => 'Please enter your email address in 100 characters or less.',
        ],
        'same' => [
            'password_confirmation' => 'The password for confirmation does not match with the password.',
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
        'title_reset_password' => 'Reset Kata Sandi',
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
        'login_title' => 'Login ke Fun! Japan',
    ],
    'label' => [
        'name_title' => 'Your Name',
        'email_title' => 'E-Mail',
        'gender_title' => 'Gender',
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
        'birthday' => 'Birthday',
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
            'step_1_title' => 'Cek benefit member Fun! Japan',
            'step_2_title' => 'Isi datamu',
            'step_3_title' => 'Registrasi selesai',
            'text_country' => 'Japan Indonesia',
        ],
        'term_title' => 'Terms and Conditions and Privacy Policy'
    ],
    'profile_page' => [
        'please_correct' => 'Please, correct the followings errors',
        'setting' => 'Settings',
        'profile' => 'Profile',
        'interest' => 'Interest',
        'madatory_field' => 'These are mandatory fields.',
        'password' => 'Password',
        'new_password' => 'New Password',
        'new_password_again' => 'New Password, Again',
        'update_complete' => 'Update completed!!',
        'title_interest' => 'What are your interest?',
        'update_setting' => 'Update Setting',
        'change_password_page_error' => 'The password of :name account cannot be set up here.
If you want to change the password of :name account, please set up a password on :name.',
    ],
    'close_page' => [
        'close_complete_title' => 'Success!!',
        'close_complete' => 'Your account left membership on this site.',
        'info_close' => 'We\'re disappointed you want to cancel membership in this website !',
        'sub_info_close' => 'Please wait a minutes before completing input to form, doesn\'t it :)',
        'title' => 'Close Account',
    ],
    'jmb' => [
        'label' => [
            'given_name' => 'Given Name',
            'family_name' => 'Family Name',
            'middle_name' => 'Middle Name',
            'pin_password' => 'Personal Identification Number (PIN)',
            'pin_confirm' => 'PIN confirmation',
            'address1' => 'Address 1',
            'address2' => 'Address 2',
            'address3' => 'Address 3',
            'address4' => 'Address 4',
            'zipcode' => 'Zip Code',
            'city' => 'Residence City',
            'country' => 'Country Of Residence',
            'phone' => 'Phone Number',
            'terms' => 'I agree to above Terms of use & Conditions',
        ],
        'text' => [
            'accept_terms' => 'Acceptance of Rules and Conditions',
            'accept_terms_warning' => 'Please agree to the JMB Rules and Conditions to continue',
        ],
        'placeholder' => [
        ''
        ],
        'validate' => [
            'required' => [
                'first_name1' => 'Please enter your given name',
                'first_name2' => 'This field is required',
                'first_name3' => 'This field is required',
                'last_name' => 'Please enter your family name',
                'password' => 'Please enter the password.',
                'password_confirmation' => 'Please enter the password for confirmation.',
                'address1' => 'This field is required',
                'address2' => 'This field is required',
                'zipcode' => 'Please enter Zip Code',
                'city' => 'Please enter your city',
                'country' => 'Please enter your country',
                'phone' => 'Please enter your phone number',
            ],
            'max' => [
                'first_name1' => 'Please enter 10 characters or less',
                'first_name2' => 'Please enter 9 characters or less',
                'first_name3' => 'Please enter 9 characters or less',
                'last_name' => 'Please enter 9 characters or less',
                'mid_name' => 'Please enter 9 characters or less',
                'address1' => 'Please enter 30 characters or less',
                'address2' => 'Please enter 30 characters or less',
                'address3' => 'Please enter 30 characters or less',
                'address4' => 'Please enter 30 characters or less',
                'phone' => 'Please enter Phone Number in 20 characters or less',
            ],
            'size' => [
                'password' => 'Please input 6 numbers',
                'password_confirmation' => 'Please input 6 numbers',
            ],
            'regex' => [
                'zipcode' => 'Please enter a valid Zip Code',
                'phone' => 'Please enter a valid phone number',
            ],
            'accepted' => [
                'terms' => 'Please agree to the JMB Rules and Conditions above',
            ],
            'confirmed' => [
                'password' => 'The password for confirmation does not match with the password.',
            ],
            'invalid_sequence_number' => [
                'password' => 'Jmb Password cannot be sequential numbers such as 123456 or 654321',
            ],
            'invalid_sequence_string' => [
                'password' => 'Jmb Password cannot be string like 111111',
            ],
        ],
    ]
];

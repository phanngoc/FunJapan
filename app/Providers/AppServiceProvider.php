<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('email_update', function ($attribute, $value, $parameters, $validator) {
            $regex = '/^[^!#$%^&*+-]+$/';

            return preg_match($regex, $value);
        });

        Validator::extend('invalid_sequence_number', function ($attribute, $value, $parameters, $validator) {
            $regex = '/(?=\d{6})(0*1*2*3*4*5*6*7*8*9*|9*8*7*6*5*4*3*2*1*0*)$/';

            return !preg_match($regex, $value);
        });

        Validator::extend('invalid_sequence_string', function ($attribute, $value, $parameters, $validator) {
            $regex = '/^([0-9])\1*$/';

            return !preg_match($regex, $value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

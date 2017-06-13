<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Category;
use App\Models\ArticleLocale;
use App\Models\Tag;

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

        Validator::extend('unique_name_category', function ($attribute, $value, $parameters, $validator) {
            if (isset($parameters[1])) {
                return !Category::where('name', $value)->where('locale_id', $parameters[0])
                    ->where('id', '<>', $parameters[1])->exists();
            }

            return !Category::where('name', $value)->where('locale_id', $parameters[0])->exists();
        }, trans('admin/category.unique_message'));

        Relation::morphMap([
            config('visit_log.relate_type.article') => ArticleLocale::class,
            config('visit_log.relate_type.tag') => Tag::class,
        ]);
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

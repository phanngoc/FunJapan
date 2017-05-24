<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer([
            'web.users.close_account',
            'web.users.close_complete',
            'web.tags.show',
            'web.categories.show',
            'web.users.interest',
            'web.users.password',
            'web.users.profile',
            ], 'App\Http\ViewComposers\BannerComposer');

        view()->composer([
            'web.tags.show',
            'web.categories.show',
            ], 'App\Http\ViewComposers\AdvertisementComposer');
    }
}

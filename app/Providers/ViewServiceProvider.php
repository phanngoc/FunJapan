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
            'web.home.index',
            'web.invite_friends.*',
            'web.guide.*',
            ], 'App\Http\ViewComposers\BannerComposer');

        view()->composer([
            'web.tags.show',
            'web.categories.show',
            'web.home.index',
            ], 'App\Http\ViewComposers\AdvertisementComposer');

        view()->composer([
            'web.home.index',
            'web.categories.show',
            'web.tags.show',
            'web.users.profile',
            'web.users.close_account',
            'web.users.interest',
            'web.users.password',
            'web.users.close_complete',
            'web.invite_friends.*',
            'web.guide.*',
            ], 'App\Http\ViewComposers\PopularPostComposer');

        view()->composer([
            'web.home.index',
            'web.invite_friends.*',
            'web.guide.*',
            'web.categories.show',
            'web.tags.show',
            'web.users.*',
        ], 'App\Http\ViewComposers\PopularSeriesComposer');

        view()->composer([
            'web.home.index',
            'web.invite_friends.*',
            'web.guide.*',
            'web.categories.show',
            'web.tags.show',
            'web.users.*',
        ], 'App\Http\ViewComposers\PopularCategoriesComposer');
    }
}

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{ asset('assets/admin/img/profile_small.jpg') }}" />
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            @can('permission', [['article.read', 'article.list', 'article.add', 'ranking.list', 'article.edit', 'article.delete']])
                <li class="{{ set_active(['admin/articles*', 'admin/articles/create', 'admin/article-comments', 'admin/clients/*', 'admin/authors/*']) }}">
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/article.article_management') }}</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li class="{{ set_active(['admin/articles']) }}">
                            <a href="{{action('Admin\ArticlesController@index')}}">{{ trans('admin/article.article_list') }}</a></li>
                        <li class="{{ set_active(['admin/articles/create']) }}">
                            <a href="{{action('Admin\ArticlesController@create')}}">{{ trans('admin/article.add_article') }}</a>
                        </li>
                        <li class="{{ set_active(['admin/article-comments']) }}">
                            <a href="{{action('Admin\ArticleCommentsController@index')}}">{{ trans('admin/article_comment.comment_list') }}</a>
                        </li>
                        @can('permission', 'article.edit')
                            <li class="{{ set_active(['admin/always-on-top']) }}">
                                <a href="{{action('Admin\ArticlesController@alwaysOnTop')}}">{{ trans('admin/article.always_on_top.label_title_menu') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            <li class="{{ set_active(['admin/tags*', 'admin/tags/create', 'admin/settingHotTags', 'admin/showHotTags']) }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/tag.tag_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ set_active(['admin/tags']) }}"><a href="{{action('Admin\TagsController@index')}}">{{ trans('admin/tag.tag_list') }}</a></li>
                    <li class="{{ set_active(['admin/tags/create']) }}">
                        <a href="{{action('Admin\TagsController@create')}}">{{ trans('admin/tag.add_tag') }}</a>
                    </li>
                    <li class="{{ set_active(['admin/settingHotTags']) }}">
                        <a href="{{action('Admin\TagsController@settingHotTags')}}">{{ trans('admin/tag.setting_hot_tags') }}</a>
                    </li>

                    <li class="{{ set_active(['admin/showHotTags']) }}">
                        <a href="{{action('Admin\TagsController@showHotTags')}}">{{ trans('admin/tag.list_hot_tags') }}</a>
                    </li>
                </ul>
            </li>

            <li class="{{ set_active(['admin/categories*', 'admin/categories/create']) }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/category.category_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ set_active(['admin/categories']) }}"><a href="{{ action('Admin\CategoriesController@index') }}">{{ trans('admin/category.category_list') }}</a></li>
                    <li class="{{ set_active(['admin/categories/create']) }}"><a href="{{ action('Admin\CategoriesController@create') }}">{{ trans('admin/category.add_category') }}</a></li>
                </ul>
            </li>

            <li class="{{ set_active(['admin/omikujis*', 'admin/omikujis/create']) }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/omikuji.omikuji_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ set_active(['admin/omikujis']) }}"><a href="{{ action('Admin\OmikujisController@index') }}">{{ trans('admin/omikuji.omikuji_list') }}</a></li>
                    <li class="{{ set_active(['admin/omikujis/create']) }}"><a href="{{ action('Admin\OmikujisController@create') }}">{{ trans('admin/omikuji.add_omikuji') }}</a></li>
                </ul>
            </li>

            {{-- <li class="{{ set_active(['admin/recommend-articles*']) }}">
                <a href="#">
                    <i class="fa fa-thumbs-up"></i>
                    <span class="nav-label">
                        {{ trans('admin/recommend_article.label.management') }}
                    </span>
                    <span class="fa arrow"></span>
                    <ul class="nav nav-second-level collapse">
                        <li class="{{ set_active(['admin/recommend-articles']) }}">
                            <a href="{{ action('Admin\RecommendedArticlesController@index') }}">
                                {{ trans('admin/recommend_article.label.set_recommend') }}
                            </a>
                        </li>
                        <li class="{{ set_active(['admin/recommend-articles/recommendedLists']) }}">
                            <a href="{{ action('Admin\RecommendedArticlesController@recommendedLists') }}">
                                {{ trans('admin/recommend_article.label.recommended_list') }}
                            </a>
                        </li>
                    </ul>
                </a>
            </li> --}}

            {{-- @can('permission', [['popular.list', 'popular.change']])
                <li class="{{ set_active(['admin/popular-articles', 'admin/popular-list']) }}">
                    <a href="#">
                        <i class="fa fa-thumbs-up"></i>
                        <span class="nav-label">
                            {{ trans('admin/popular_article.label.management') }}
                        </span>
                        <span class="fa arrow"></span>
                        <ul class="nav nav-second-level collapse">
                            @can('permission', 'popular.change')
                                <li>
                                    <a href="{{ action('Admin\PopularArticlesController@index') }}">
                                        {{ trans('admin/popular_article.label.set_recommend') }}
                                    </a>
                                </li>
                            @endcan

                            @can('permission', 'popular.list')
                                <li>
                                    <a href="{{ action('Admin\PopularArticlesController@popularLists') }}">
                                        {{ trans('admin/popular_article.label.recommended_list') }}
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </a>
                </li>
            @endcan --}}

            @can('permission', [['survey.list', 'survey.add']])
                <li class="{{ set_active(['admin/surveys*', 'admin/surveys/create']) }}">
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/survey.survey_management') }}</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @can('permission', 'survey.list')
                            <li><a href="{{ action('Admin\SurveysController@index') }}">{{ trans('admin/survey.survey_list') }}</a></li>
                        @endcan
                        @can('permission', 'survey.add')
                            <li><a href="{{ action('Admin\SurveysController@create') }}">{{ trans('admin/survey.add_survey') }}</a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('permission', [['api.list', 'banner.change', 'ranking.list', 'advertisement.change']])
                <li class="{{ set_active(['admin/setting/*']) }}">
                    <a href="#">
                        <i class="fa fa-thumbs-up"></i>
                        <span class="nav-label">
                            {{ trans('admin/popular_article.setting_management') }}
                        </span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        @can('permission', 'banner.change')
                            <li>
                                <a href="{{action('Admin\BannerSettingsController@index')}}">
                                    {{ trans('admin/banner.label_banner') }}
                                </a>
                            </li>
                        @endcan

                        {{-- @can('permission', 'ranking.list')
                            <li>
                                <a href="{{action('Admin\ArticleRanksController@index')}}">
                                    {{ trans('admin/article_rank.label') }}
                                </a>
                            </li>
                        @endcan --}}

                        @can('permission', 'api.list')
                            <li>
                                <a href="{{action('Admin\ApiTokenController@index')}}">
                                    {{ trans('admin/api_token.label_title') }}
                                </a>
                            </li>
                        @endcan

                        @can('permission', 'advertisement.change')
                            <li>
                                <a href="{{action('Admin\AdvertisementsController@index')}}">
                                    {{ trans('admin/advertisement.label_title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            {{-- <li class="{{ set_active(['admin/menus*', 'admin/menus/create']) }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/menu.menu_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="{{action('Admin\MenusController@index')}}">{{ trans('admin/menu.menu_list') }}</a>
                    </li>
                    <li>
                        <a href="{{action('Admin\MenusController@create')}}">{{ trans('admin/menu.add_menu') }}</a>
                    </li>
                </ul>
            </li> --}}

            {{-- <li class="{{ set_active(['admin/popular-series*']) }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/popular_series.popular_series_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="{{action('Admin\PopularSeriesController@index')}}">
                            {{ trans('admin/popular_series.list_series') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{action('Admin\PopularSeriesController@create')}}">
                            {{ trans('admin/popular_series.setting_series') }}
                        </a>
                    </li>
                </ul>
            </li> --}}

            <li class="{{ set_active(['admin/coupons*']) }}">
                <a href="#"><i class="fa fa-tags"></i> <span class="nav-label">{{ trans('admin/coupon.coupon_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="{{action('Admin\CouponsController@index')}}">{{ trans('admin/coupon.coupon_list') }}</a>
                    </li>
                    <li>
                        <a href="{{action('Admin\CouponsController@create')}}">{{ trans('admin/coupon.add_coupon') }}</a>
                    </li>
                </ul>
            </li>

            {{-- <li class="{{ set_active(['admin/popular-category*']) }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/popular_category.popular_category_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="{{action('Admin\PopularCategoriesController@index')}}">
                            {{ trans('admin/popular_category.list_category') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{action('Admin\PopularCategoriesController@create')}}">
                            {{ trans('admin/popular_category.setting_category') }}
                        </a>
                    </li>
                </ul>
            </li> --}}

            <li class="{{ set_active(['admin/roles*']) }}">
                <a href="javascript:;">
                    <i class="fa fa-wrench"></i>
                    <span class="nav-label">{!! trans('admin/roles.label.management') !!}</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="{!! action('Admin\RolesController@index') !!}">
                            {!! trans('admin/roles.label.list') !!}
                        </a>
                    </li>
                    <li>
                        <a href="{!! action('Admin\RolesController@create') !!}">
                            {!! trans('admin/roles.label.add') !!}
                        </a>
                    </li>
                    <li>
                        <a href="{!! action('Admin\RolesController@getUsersRole') !!}">
                            {!! trans('admin/roles.label.user_role') !!}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ set_active(['admin/id*']) }}">
                <a href="{!! action('Admin\IdsController@index') !!}">
                    <i class="fa fa-sitemap"></i> <span class="nav-label"> {{ trans('admin/client.id_management') }}
                </a>
            </li>
        </ul>
    </div>
</nav>

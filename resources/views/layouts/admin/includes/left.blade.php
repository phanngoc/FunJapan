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
            <li class="{{ set_active(['admin/articles*', 'admin/articles/create']) }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/article.article_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ set_active(['admin/articles']) }}"><a href="{{action('Admin\ArticlesController@index')}}">{{ trans('admin/article.article_list') }}</a></li>
                    <li class="{{ set_active(['admin/articles/create']) }}">
                        <a href="{{action('Admin\ArticlesController@create')}}">{{ trans('admin/article.add_article') }}</a>
                    </li>
                </ul>
            </li>
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
                    <li><a href="{{ action('Admin\CategoriesController@index') }}">{{ trans('admin/category.category_list') }}</a></li>
                    <li><a href="{{ action('Admin\CategoriesController@create') }}">{{ trans('admin/category.add_category') }}</a></li>
                </ul>
            </li>

            <li class="{{ set_active(['admin/omikujis*']) }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/omikuji.omikuji_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ action('Admin\OmikujisController@index') }}">{{ trans('admin/omikuji.omikuji_list') }}</a></li>
                    <li><a href="{{ action('Admin\OmikujisController@create') }}">{{ trans('admin/omikuji.add_omikuji') }}</a></li>
                </ul>
            </li>

            <li class="{{ set_active(['admin/recommend-articles*']) }}">
                <a href="#">
                    <i class="fa fa-thumbs-up"></i>
                    <span class="nav-label">
                        {{ trans('admin/recommend_article.label.management') }}
                    </span>
                    <span class="fa arrow"></span>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ action('Admin\RecommendedArticlesController@index') }}">
                                {{ trans('admin/recommend_article.label.set_recommend') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ action('Admin\RecommendedArticlesController@recommendedLists') }}">
                                {{ trans('admin/recommend_article.label.recommended_list') }}
                            </a>
                        </li>
                    </ul>
                </a>
            </li>

            <li class="{{ set_active(['admin/setting/popular-articles', 'admin/popular-list']) }}">
                <a href="#">
                    <i class="fa fa-thumbs-up"></i>
                    <span class="nav-label">
                        {{ trans('admin/popular_article.label.management') }}
                    </span>
                    <span class="fa arrow"></span>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ action('Admin\PopularArticlesController@index') }}">
                                {{ trans('admin/popular_article.label.set_recommend') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ action('Admin\PopularArticlesController@popularLists') }}">
                                {{ trans('admin/popular_article.label.recommended_list') }}
                            </a>
                        </li>
                    </ul>
                </a>
            </li>

            <li class="{{ set_active(['admin/surveys*', 'admin/surveys/create']) }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/survey.survey_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{ action('Admin\SurveysController@index') }}">{{ trans('admin/survey.survey_list') }}</a></li>
                    <li><a href="{{ action('Admin\SurveysController@create') }}">{{ trans('admin/survey.add_survey') }}</a></li>
                </ul>
            </li>

            <li class="{{ set_active(['admin/setting/banner', 'admin/setting/rank']) }}">
                <a href="#">
                    <i class="fa fa-thumbs-up"></i>
                    <span class="nav-label">
                        {{ trans('admin/popular_article.setting_management') }}
                    </span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="{{action('Admin\BannerSettingsController@index')}}">
                            {{ trans('admin/banner.label_banner') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{action('Admin\ArticleRanksController@index')}}">
                            {{ trans('admin/article_rank.label') }}
                        </a>
                    </li>
                </ul>
            </li>

            <li class="{{ set_active(['admin/menus*', 'admin/menus/create']) }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/menu.menu_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="{{action('Admin\MenusController@index')}}">{{ trans('admin/menu.menu_list') }}</a>
                    </li>
                    <li>
                        <a href="{{action('Admin\MenusController@create')}}">{{ trans('admin/menu.add_menu') }}</a>
                    </li>
                </ul>
            </li>

            <li class="{{ set_active(['admin/popular-series*']) }}">
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
            </li>

        </ul>
    </div>
</nav>

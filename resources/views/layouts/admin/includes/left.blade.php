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
            @can('permission', [['article.read', 'article.list', 'article.add', 'article.edit', 'article.delete']])
                <li class="{{ set_active(['admin/articles', 'admin/articles/create', 'admin/article-comments']) }}">
                    <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/article.article_management') }}</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @can('permission', [['article.read', 'article.list']])
                        <li class="{{ set_active(['admin/articles']) }}">
                            <a href="{{action('Admin\ArticlesController@index')}}">{{ trans('admin/article.article_list') }}</a>
                        </li>
                        @endcan
                        @can('permission', [['article.add']])
                        <li class="{{ set_active(['admin/articles/create']) }}">
                            <a href="{{action('Admin\ArticlesController@create')}}">{{ trans('admin/article.add_article') }}</a>
                        </li>
                        @endcan
                        @can('permission', [['article.comment.list']])
                        <li class="{{ set_active(['admin/article-comments']) }}">
                            <a href="{{action('Admin\ArticleCommentsController@index')}}">{{ trans('admin/article_comment.comment_list') }}</a>
                        </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('permission', [['client.list', 'author.list', 'tag.add', 'tag.list', 'tag.setting.hot', 'tag.show.hot']])
            <li class="{{ set_active(['admin/id*', 'admin/tags*', 'admin/settingHotTags', 'admin/showHotTags', 'admin/setting/advertisements']) }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/client.id_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    @can('permission', [['client.list']])
                    <li class="{{ set_active(['admin/id?tab=client']) }}">
                        <a href="{!! action('Admin\IdsController@index', ['tab' => 'client']) !!}">
                            <i class="fa fa-cubes"></i> <span class="nav-label"> {{ trans('admin/client.label.client_id') }}</span>
                        </a>
                    </li>
                    @endcan
                    @can('permission', [['author.list']])
                    <li class="{{ set_active(['admin/id?tab=author']) }}">
                        <a href="{!! action('Admin\IdsController@index', ['tab' => 'author']) !!}">
                            <i class="fa fa-users"></i> <span class="nav-label"> {{ trans('admin/author.label.author') }}</span>
                        </a>
                    </li>
                    @endcan
                    @can('permission', [['client.list']])
                    <li class="{{ set_active(['admin/tags*', 'admin/settingHotTags', 'admin/showHotTags']) }}">
                        <a href="#"><i class="fa fa-tags"></i> <span class="nav-label">{{ trans('admin/tag.tag_management') }}</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level collapse">
                            @can('permission', [['tag.list']])
                            <li class="{{ set_active(['admin/tags']) }}">
                                <a href="{{action('Admin\TagsController@index')}}">{{ trans('admin/tag.tag_list') }}</a>
                            </li>
                            @endcan
                            @can('permission', [['tag.add']])
                            <li class="{{ set_active(['admin/tags/create']) }}">
                                <a href="{{action('Admin\TagsController@create')}}">{{ trans('admin/tag.add_tag') }}</a>
                            </li>
                            @endcan
                            @can('permission', [['tag.setting.hot']])
                            <li class="{{ set_active(['admin/settingHotTags']) }}">
                                <a href="{{action('Admin\TagsController@settingHotTags')}}">{{ trans('admin/tag.setting_hot_tags') }}</a>
                            </li>
                            @endcan
                            @can('permission', [['tag.show.hot']])
                            <li class="{{ set_active(['admin/showHotTags']) }}">
                                <a href="{{action('Admin\TagsController@showHotTags')}}">{{ trans('admin/tag.list_hot_tags') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @can('permission', 'advertisement.change')
                        <li class="{{ set_active(['admin/setting/advertisements']) }}">
                            <a href="{{action('Admin\AdvertisementsController@index')}}">
                                <i class="fa fa-money"></i><span class="nav-label">{{ trans('admin/advertisement.label_title') }}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('permission', [['article.edit', 'banner.change', 'editor_choice.list']])
            <li class="{{ set_active(['admin/editor-choices*', 'admin/articles/always-on-top', 'admin/setting/banner']) }}">
                <a href="#"><i class="fa fa-sitemap"></i> <span class="nav-label">{{ trans('admin/article.label.other_management') }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    @can('permission', 'editor_choice.list')
                    <li class="{{ set_active(['admin/editor-choices*']) }}">
                        <a href="{{action('Admin\EditorChoicesController@index')}}">
                            <i class="fa fa-wrench"></i>
                            <span class="nav-label">{{ trans('admin/editor_choices.editor_choices') }}</span>
                        </a>
                    </li>
                    @endcan
                    @can('permission', 'article.edit')
                        <li class="{{ set_active(['admin/articles/always-on-top']) }}">
                            <a href="{{action('Admin\ArticlesController@alwaysOnTop')}}">
                                <i class="fa fa-bolt"></i>
                                <span class="nav-label">
                                    {{ trans('admin/article.always_on_top.label_title_menu') }}
                                </span>
                            </a>
                        </li>
                    @endcan
                    @can('permission', 'banner.change')
                        <li class="{{ set_active(['admin/setting/banner']) }}">
                            <a href="{{action('Admin\BannerSettingsController@index')}}">
                                <i class="fa fa-sliders"></i>
                                <span class="nav-label">
                                    {{ trans('admin/banner.label_banner') }}
                                </span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcan

            @can('permission', [['api.list']])
                <li class="{{ set_active(['admin/setting/api-token-list']) }}">
                    <a href="#">
                        <i class="fa fa-thumbs-up"></i>
                        <span class="nav-label">
                            {{ trans('admin/banner.setting_management') }}
                        </span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        @can('permission', 'api.list')
                            <li>
                                <a href="{{action('Admin\ApiTokenController@index')}}">
                                    {{ trans('admin/api_token.label_title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('permission', [['role.list', 'role.add', 'role.change']])
            <li class="{{ set_active(['admin/roles*']) }}">
                <a href="javascript:;">
                    <i class="fa fa-wrench"></i>
                    <span class="nav-label">{!! trans('admin/roles.label.management') !!}</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    @can('permission', [['role.list']])
                    <li>
                        <a href="{!! action('Admin\RolesController@index') !!}">
                            {!! trans('admin/roles.label.list') !!}
                        </a>
                    </li>
                    @endcan
                    @can('permission', [['role.add']])
                    <li>
                        <a href="{!! action('Admin\RolesController@create') !!}">
                            {!! trans('admin/roles.label.add') !!}
                        </a>
                    </li>
                    @endcan
                    @can('permission', [['role.change']])
                    <li>
                        <a href="{!! action('Admin\RolesController@getUsersRole') !!}">
                            {!! trans('admin/roles.label.user_role') !!}
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
        </ul>
    </div>
</nav>

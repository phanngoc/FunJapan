<!-- NAVBAR -->
<div class="fj-navbar">
    <div class="container">
        <nav class="navbar navbar-default">
            <ul class="nav navbar-nav">
                @if (isset($menu))
                    @foreach ($menu as $m)
                        @if ($m->type == config('menu.parent_type.link'))
                            <li class="">
                                <a href="{{ $m->link }}">
                                    @if ($m->icon_class)
                                        <i class="{{ $m->icon_class }}"></i>
                                    @else
                                        <img class="icon-menu" src="{{ $m->icon_url['normal'] }}">
                                    @endif
                                    <span>{{ $m->name }}</span>
                                </a>
                            </li>
                        @else
                            <li class="dropdown">
                                @if ($m->type == config('menu.parent_type.mix'))
                                    <a data-toggle="tab" href="#dropdown-{{ $m->id }}" class="fj-tab">
                                @elseif ($m->type == config('menu.parent_type.category'))
                                    <a data-toggle="tab" href="#dropdown-category-{{ $m->id }}" class="fj-tab">
                                @elseif ($m->type == config('menu.parent_type.tag'))
                                    <a data-toggle="tab" href="#dropdown-tags-{{ $m->id }}" class="fj-tab">
                                @endif
                                @if ($m->icon_class)
                                    <i class="{{ $m->icon_class }}"></i>
                                    <span>{{ $m->name }}</span>
                                @else
                                    <img class="icon-menu" src="{{ $m->icon_url['normal'] }}">
                                    <span>{{ $m->name }}</span>
                                    <i class="fa fa-chevron-down"></i>
                                @endif
                                </a>
                                <div class="caret-up">
                                    <i class="fa fa-caret-up"></i>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ trans('web/global.link.facebook') }}" target="_blank">
                        <i class="fa fa-facebook-square"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ trans('web/global.link.twitter') }}" target="_blank">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ trans('web/global.link.instagram') }}" target="_blank">
                        <i class="fa fa-instagram"></i>
                    </a>
                </li>
                <li>
                    <a href="{{ trans('web/global.link.youtube') }}" target="_blank">
                        <i class="fa fa-youtube-play"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="tab-content">
            @if (isset($menu))
                @foreach ($menu as $m)
                    @if ($m->type == config('menu.parent_type.mix'))
                        <div id="dropdown-{{ $m->id }}" class="tab-pane navbar-tab fade">
                            <ul class="tab-content-menu">
                                @foreach ($m->children as $mChildren)
                                    <li class="vertical-bar"><a href="#">|</a></li>
                                    <li><a href="{{ $mChildren->link }}">{{ $mChildren->name }}</a></li>
                                @endforeach
                                <li class="vertical-bar"><a href="#">|</a></li>
                            </ul>
                        </div>
                    @elseif ($m->type == config('menu.parent_type.category'))
                        <div id="dropdown-category-{{ $m->id }}" class="tab-pane navbar-tab fade">
                            <ul class="tab-content-menu">
                                <li class="vertical-bar"><a href="#">|</a></li>
                                <li><a href="{{ action('Web\HomesController@index') }}">{{ trans('web/top_page.all') }}</a></li>
                                @if (!is_null($m->categories))
                                    @foreach ($m->categories as $category)
                                        <li class="vertical-bar"><a href="#">|</a></li>
                                        <li><a href="{{ action('Web\CategoriesController@show', $category->short_name) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                @endif
                                <li class="vertical-bar"><a href="#">|</a></li>
                            </ul>
                        </div>
                    @elseif ($m->type == config('menu.parent_type.tag'))
                        <div id="dropdown-tags-{{ $m->id }}" class="tab-pane navbar-tab fade">
                            <ul class="tab-content-menu">
                                @if (!is_null($m->tags))
                                    @foreach ($m->tags as $tag)
                                        <li class="hot-tags">
                                            <a href="{{ action('Web\TagsController@show', $tag->name) }}">
                                                <span class="hashtag">#</span> {{ $tag->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>

<div class="fj-navbar-mobile" id="nav-affix">
    <div class="container">
        <ul class="list-inline">
            @if (isset($menu))
                @foreach ($menu as $m)
                    @if ($m->type == config('menu.parent_type.link'))
                        <li class="">
                            <a href="{{ $m->link }}">
                                <span>{{ $m->name }}</span>
                            </a>
                        </li>
                    @else
                        <li class="dropdown">
                            @if ($m->type == config('menu.parent_type.mix'))
                                <a data-toggle="tab" href="#sm-dropdown-{{ $m->id }}" class="fj-tab">
                            @elseif ($m->type == config('menu.parent_type.category'))
                                <a data-toggle="tab" href="#sm-dropdown-category-{{ $m->id }}" class="fj-tab">
                            @elseif ($m->type == config('menu.parent_type.tag'))
                                <a data-toggle="tab" href="#sm-dropdown-tags-{{ $m->id }}" class="fj-tab">
                            @endif
                                <span>{{ $m->name }}</span>
                            </a>
                            <div class="caret-up">
                                <i class="fa fa-caret-up"></i>
                            </div>
                        </li>
                    @endif
                @endforeach
            @endif
            <li class="dropdown">
                <a class="fj-tab" data-toggle="tab" href="#sm-social-dropdown">
                    <span>SOCIAL</span>
                </a>
                <div class="caret-up">
                    <i class="fa fa-caret-up"></i>
                </div>
            </li>
            <li class="dropdown">
                <a class="fj-tab" data-toggle="tab" href="#sm-legal-dropdown">
                    <span>LEGAL</span>
                </a>
                <div class="caret-up">
                    <i class="fa fa-caret-up"></i>
                </div>
            </li>
            <li class="dropdown" id="lastitem">
                <a class="fj-tab" data-toggle="tab" href="#sm-info-dropdown">
                    <span>FURTHER INFO</span>
                </a>
                <div class="caret-up">
                    <i class="fa fa-caret-up"></i>
                </div>
            </li>
        </ul>
    </div>
    <div class="tab-content">
        @if (isset($menu))
            @foreach ($menu as $m)
                @if ($m->type == config('menu.parent_type.mix'))
                    <div id="sm-dropdown-{{ $m->id }}" class="tab-pane navbar-tab fade">
                        <ul class="tab-content-menu">
                            @foreach ($m->children as $mChildren)
                                <li class="vertical-bar"><a href="#">|</a></li>
                                <li><a href="{{ $mChildren->link }}">{{ $mChildren->name }}</a></li>
                            @endforeach
                            <li class="vertical-bar"><a href="#">|</a></li>
                        </ul>
                    </div>
                @elseif ($m->type == config('menu.parent_type.category'))
                    <div id="sm-dropdown-category-{{ $m->id }}" class="tab-pane navbar-tab fade">
                        <ul class="tab-content-menu">
                            <li class="vertical-bar"><a href="#">|</a></li>
                            <li><a href="{{ action('Web\HomesController@index') }}">{{ trans('web/top_page.all') }}</a></li>
                            @if (!is_null($m->categories))
                                @foreach ($m->categories as $category)
                                    <li class="vertical-bar"><a href="#">|</a></li>
                                    <li><a href="{{ action('Web\CategoriesController@show', $category->short_name) }}">{{ $category->name }}</a></li>
                                @endforeach
                            @endif
                            <li class="vertical-bar"><a href="#">|</a></li>
                        </ul>
                    </div>
                @elseif ($m->type == config('menu.parent_type.tag'))
                    <div id="sm-dropdown-tags-{{ $m->id }}" class="tab-pane navbar-tab fade">
                        <ul class="tab-content-menu">
                            @if (!is_null($m->tags))
                                @foreach ($m->tags as $tag)
                                    <li class="hot-tags">
                                        <a href="{{ action('Web\TagsController@show', $tag->name) }}">
                                            <span class="hashtag">#</span> {{ $tag->name }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endif
            @endforeach
        @endif
        <div class="tab-pane navbar-tab fade" id="sm-social-dropdown">
            <div class="sns-btn-fanpage">
                <ul class="list-inline">
                    <li>
                        <a class="btn btn-sns" href="{{ trans('web/global.link.facebook') }}">
                            <i class="fa fa-facebook-square" aria-hidden="true"></i>
                            <span>&nbsp;Facebook</span>
                        </a>
                    </li>
                    <li>
                        <a class="btn btn-sns" href="{{ trans('web/global.link.twitter') }}">
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                            <span>&nbsp;Twitter</span>
                        </a>
                    </li>
                    <li>
                        <a class="btn btn-sns" href="{{ trans('web/global.link.instagram') }}">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                            <span>&nbsp;Instagram</span>
                        </a>
                    </li>
                    <li>
                        <a class="btn btn-sns" href="{{ trans('web/global.link.youtube') }}">
                            <i class="fa fa-youtube-play" aria-hidden="true"></i>
                            <span>&nbsp;Youtube</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-pane navbar-tab fade" id="sm-legal-dropdown">
            <ul class="tab-content-menu">
                <li class="vertical-bar">
                    <a href="#">|</a>
                </li>
                <li>
                    <a href="{{ action('Web\GuidesController@termsAndConditions') }}">TERMS &amp; CONDITIONS</a>
                </li>
                <li class="vertical-bar">
                    <a href="#">|</a>
                </li>
                <li>
                    <a href="{{ action('Web\GuidesController@privacyPolicies') }}">PRIVACY POLICIES</a>
                </li>
                <li class="vertical-bar">
                    <a href="#">| </a>
                </li>
            </ul>
        </div>
        <div class="tab-pane navbar-tab fade" id="sm-info-dropdown">
            <ul class="tab-content-menu">
                <li class="vertical-bar">
                    <a href="#">|</a>
                </li>
                <li>
                    <a href="{{ action('Web\GuidesController@faq') }}">FAQ</a>
                </li>
                <li class="vertical-bar">
                    <a href="#">|</a>
                </li>
                <li>
                    <a href="{{ action('Web\GuidesController@contactUs') }}">CONTACT US</a>
                </li>
                <li class="vertical-bar">
                    <a href="#">|</a>
                </li>
                <li>
                    <a href="{{ action('Web\GuidesController@inquiry') }}">FOR MARKETERS</a>
                </li>
                <li class="vertical-bar">
                    <a href="#">| </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- EOF NAVBAR -->

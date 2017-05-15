<!-- NAVBAR -->
<div class="fj-navbar nav-desktop">
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
                                    {{ $m->name }}
                                </a>
                            </li>
                        @else
                            <li class="dropdown">
                                @if ($m->type == config('menu.parent_type.mix'))
                                    <a data-toggle="tab" href="#dropdown-{{ $m->id }}" class="fj-tab">
                                @elseif ($m->type == config('menu.parent_type.category'))
                                    <a data-toggle="tab" href="#dropdown-category" class="fj-tab">
                                @elseif ($m->type == config('menu.parent_type.tag'))
                                    <a data-toggle="tab" href="#dropdown-tags" class="fj-tab">
                                @endif
                                @if ($m->icon_class)
                                    <i class="{{ $m->icon_class }}"></i>{{ $m->name }} <i class="fa fa-chevron-down"></i>
                                @else
                                    <img class="icon-menu" src="{{ $m->icon_url['normal'] }}">{{ $m->name }} <i class="fa fa-chevron-down"></i>
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
                        <div id="dropdown-category" class="tab-pane navbar-tab fade">
                            <ul class="tab-content-menu">
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
                        <div id="dropdown-tags" class="tab-pane navbar-tab fade">
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

<div class="navigation fj-navbar-mobile" id="nav-affix">
    <div class="container">
        <ul class="list-inline">
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
                                {{ $m->name }}
                            </a>
                        </li>
                    @else
                        <li class="dropdown">
                            @if ($m->type == config('menu.parent_type.mix'))
                                <a data-toggle="tab" href="#sm-dropdown-{{ $m->id }}" class="fj-tab">
                            @elseif ($m->type == config('menu.parent_type.category'))
                                <a data-toggle="tab" href="#sm-dropdown-category" class="fj-tab">
                            @elseif ($m->type == config('menu.parent_type.tag'))
                                <a data-toggle="tab" href="#sm-dropdown-tags" class="fj-tab">
                            @endif
                            @if ($m->icon_class)
                                <i class="{{ $m->icon_class }}"></i>{{ $m->name }} <i class="fa fa-chevron-down"></i>
                            @else
                                <img class="icon-menu" src="{{ $m->icon_url['normal'] }}">{{ $m->name }} <i class="fa fa-chevron-down"></i>
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
                    <div id="sm-dropdown-category" class="tab-pane navbar-tab fade">
                        <ul class="tab-content-menu">
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
                    <div id="sm-dropdown-tags" class="tab-pane navbar-tab fade">
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
<!-- EOF NAVBAR -->

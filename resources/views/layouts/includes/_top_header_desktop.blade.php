<a class="header__sitename" href="/">
    <span class="header__sitename-red">{{ trans('web/global.app_name') }}</span>
    <span class="header__sitename-black">{{ trans('web/global.site_name') }}</span>
</a>
<form class="header__search" role="form" action="/Search" method="get">
    <input type="text" placeholder="Search">
    <i class="fa fa-search"></i>
</form>
<a class="header__advanced-search" href="#">
    <span>Advanced</span>
</a>
@if (auth()->check())
    @include('layouts.includes.notifications')
@endif
<div class="user-settings">
    @if (!auth()->check())
        <ul class="nav">
            <li class="dropdown dropdown--unauthen">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                    <i class="zmdi zmdi-account-circle"></i>
                </a>
                <div class="dropdown-menu">
                    <ul class="list-items">
                        <li>
                            <a href="{{ action('Web\RegisterController@create') }}">
                                <i class="fa fa-unlock-alt"></i> Register
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login') }}">
                                <i class="fa fa-user"></i> Login
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    @else
        @include('layouts.includes.user_logined_control', ['user' => auth()->user()])
    @endif
</div>
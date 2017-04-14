<div class="top-header">
    <div class="header-text">
        <p class="header-title-text">
            <a href="/">
                <img src="assets/images/brand-icon.png" alt="brand-icon">
                    <span>&nbsp;FUN!
                        <span class="title-country">&nbsp;Japan Indonesia</span>
                    </span>
            </a>
        </p>
    </div>
    <div class="header-right">
        <form role="form" action="/Search" method="get">
            <input type="text" placeholder="Type in keyword">
            <i class="fa fa-search form-control-feedback"></i>
        </form>
        <div class="user-setting">
            @if (!auth()->check())
                <div class="authentication">
                    <a class="authen-link" href="{{ action('Web\RegisterController@create') }}">
                        <i class="fa fa-unlock-alt"></i> Register</a>
                    <span class="authen-link">/</span>
                    <a class="authen-link" href="{{ route('login') }}"><i class="fa fa-user"></i> Login</a>
                </div>
            @else
                @include('layouts.includes.user_logined_control', ['user' => auth()->user()])
            @endif
        </div>
    </div>
</div>
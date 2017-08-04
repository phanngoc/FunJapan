<ul class="nav">
    <li class="dropdown">
        <a class="dropdown-toggle" href="#" data-toggle="dropdown">
            <i class="zmdi zmdi-account-circle"></i>
        </a>
        <div class="dropdown-menu">
            <div class="box-sum-ranking">
                <div class="bsr-sum-left">
                    <img src="https://malaysia.fun-japan.jp/~/media/Mpf/Website/UserRank/ic_regular.ashx">
                    <div class="bsr-detail">
                        <div class="brs-title">Bronze</div>
                        <div class="brs-month">Next month : </div>
                        <div class="brs-promotion">Regular (stay)</div>
                    </div>
                </div>
                <div class="brs-point">
                    <span class="point">{{ $user->point }} </span>
                    <span class="currence">Points</span>
                </div>
                <div class="brs-star">
                    <span class="star is-checked"></span>
                    <span class="star is-checked"></span>
                    <span class="star"></span>
                    <span class="star"></span>
                </div>
            </div>
            <ul class="list-items">
                <li>
                    <a href="#">My Coupons</a>
                </li>
                <li>
                    <a href="{{ route('profile') }}">Settings</a>
                </li>
                <li>
                    <a href="#">About Member Program</a>
                </li>
                <li>
                    <a href="{{ action('Web\LoginController@logout') }}">
                        <i class="zmdi zmdi-account"></i> Logout</a>
                </li>
            </ul>
        </div>
    </li>
</ul>
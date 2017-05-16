<div class="user-preference">
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                <span><i class="fa fa-user-circle"></i></span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <div class="dropdown-menu-global">
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
                                    <i class="zmdi zmdi-account"></i> Logout
                                </a>
                            </li>
                        </ul>

                        <div class="box-sum-ranking">
                            <!-- Row Summary -->
                            <div class="row brs-sum">
                                <!-- column left -->
                                <div class="col-md-6 bsr-sum-left">
                                    <img src="https://malaysia.fun-japan.jp/~/media/Mpf/Website/UserRank/ic_regular.ashx">
                                    <div class="bsr-detail">
                                        <div class="brs-title">Regular</div>
                                        <div class="brs-month">Next month :</div>
                                        <div class="brs-promotion">Regular (stay)</div>
                                    </div>
                                </div>
                                <!-- ./Column left -->
                                <!-- Column right -->
                                <div class="col-md-6 brs-point">
                                    <strong>{{ $user->point }}</strong> <span class="currence">Points</span>
                                </div>
                                <!-- Column right -->
                            </div>
                            <!-- ./Row Summary -->
                            <!-- Row detail ratting -->
                            <div class="row brs-star">
                                <div class="col-md-2">
                                    <strong>Regular</strong>
                                </div>
                                <div class="col-md-10">
                                    <span class="star is-checked"></span>
                                    <span class="star"></span>
                                    <span class="star"></span>
                                </div>
                            </div>
                            <!-- ./Row detail ratting -->
                        </div>
                    </div>
                </li>
            </ul>
        </li>
        <li class="navbar-text">
            <span>{{ $user->name }}</span>
        </li>
    </ul>
</div>

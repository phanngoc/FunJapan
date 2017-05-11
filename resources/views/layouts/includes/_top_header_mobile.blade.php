<div class="top-header-mobile">
    <span class="header-title-text">
        <a href="/">
            <img src="assets/images/brand-icon.png" alt="brand-icon">
            <span>
                {!! trans('web/global.app_name', [
                    'sitename' => '<small class="title-country">' . trans('web/global.site_name') . '</small>'
                ]) !!}
            </span>
        </a>
    </span>
    <div class="user-setting pull-right">
        <div class="user-preference">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <!-- If authenticated -->
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <span><i class="zmdi zmdi-account-circle pink"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="dropdown-menu-global">
                                <!-- If is authenticated-->
                                <div class="box-sum-ranking">
                                    <div class="bsr-sum-left">
                                        <img src="assets/images/ic_bronze.png">
                                        <div class="bsr-detail">
                                            <div class="brs-title">Bronze</div>
                                            <div class="brs-month">Next month :</div>
                                            <div class="brs-promotion">Regular (stay)</div>
                                        </div>
                                    </div>
                                    <div class="brs-point">
                                        <span class="point">6,070 </span><span class="currence">Points</span>
                                    </div>
                                    <!-- Row detail ratting -->
                                    <div class="brs-star">
                                        <span class="star is-checked"></span>
                                        <span class="star is-checked"></span>
                                        <span class="star is-checked"></span>
                                        <span class="star is-checked"></span>
                                        <span class="star is-checked"></span>
                                        <span class="star is-checked"></span>
                                        <span class="star is-checked"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                        <span class="star"></span>
                                    </div>
                                    <!-- ./Row detail ratting -->
                                </div>
                                <ul class="list-items">
                                    <li>
                                        <a href="#">My Coupons</a>
                                    </li>
                                    <li>
                                        <a href="#">Settings</a>
                                    </li>
                                    <li>
                                        <a href="#">About Member Program</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="zmdi zmdi-account"></i> Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <!-- If not authenticated -->
                    <a class="dropdown-toggle" href="#" data-toggle="dropdown" style="display: none">
                        <span><i class="zmdi zmdi-account-circle black"></i></span>
                    </a>
                    <ul class="dropdown-menu" style="display: none">
                        <li>
                            <!-- If not authenticated -->
                            <div class="dropdown-menu-global unauthen">
                                <ul class="list-items">
                                    <li>
                                        <a href="#"><i class="fa fa-unlock-alt"></i> Register</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-user"></i> Login</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <form class="pull-right" role="form" action="/Search" method="get">
        <input type="text" placeholder="Type in keyword">
        <span class="vertical-bar">| </span>
        <i class="fa fa-search form-control-feedback"></i>
    </form>
</div>
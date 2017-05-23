<div class="registration-header">
    <div class="registration-title">
        <a href="#">
            <p class="registration-logo">
                <span>FJ</span>
            </p>
            <p class="web-title">
                <span class="text-fun">FUN!</span>
                <span class="text-country">{{ trans('web/user.register_page.banner.text_country') }}</span>
            </p>
        </a>
    </div>
    <div class="registration-navigation">
        <ul class="list-inline step">
            <li class="step-item step-item--1 {{ isset($step) && $step == 1 ? 'active' : '' }}">
                <span>1</span>
                <p class="vertical-bar"></p>
                <p class="step-des-item"><span class="step-des">{{ trans('web/user.register_page.banner.step_1_title') }}</span></p>
                <li class="horizontal-bar"></li>
            <li class="step-item step-item--2 {{ isset($step) && $step == 2 ? 'active' : '' }}">
                <span>2</span>
                <p class="vertical-bar"></p>
                <p class="step-des-item"><span class="step-des">{{ trans('web/user.register_page.banner.step_2_title') }}</span></p>
            </li>
            <li class="horizontal-bar"></li>
            <li class="step-item step-item--3 {{ isset($step) && $step == 3 ? 'active' : '' }}">
                <span>3</span>
                <p class="vertical-bar"></p>
                <p class="step-des-item"><span class="step-des">{{ trans('web/user.register_page.banner.step_3_title') }}</span></p>
            </li>
        </ul>
    </div>
    <div class="header-boder"></div>
</div>

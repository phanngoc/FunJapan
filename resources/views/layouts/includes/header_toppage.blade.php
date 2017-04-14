<!-- HEADER -->
<!-- Menu bars -->
<header class="global-header">
    <!-- Top header bar -->
    @include('layouts.includes._top_header_desktop')

    <!-- Top header bar mobile -->
    @include('layouts.includes._top_header_mobile')
    <!-- SLIDER -->
    <div id="banner-top-sliderFrame">
        <!-- MAIN IMAGES -->
        <div id="banner-top-slider">
            <a class="lazyImage" href="assets/images/top/main_img_01.jpg" title="#htmlcaption1"></a>
            <a class="lazyImage" href="assets/images/top/main_img_2.jpg" title="#htmlcaption2"></a>
            <a class="lazyImage" href="assets/images/top/main_img_3.jpg" title="#htmlcaption3"></a>
        </div>
        <!-- MAIN IMAGES -->
        <!-- CAPTIONS -->
        <div style="display: none;">
            <div id="htmlcaption1">
                <a href="#">
                    <div class="content">
                        <p class="heading">Oshibori (sdxxdd) Fun! Japan Words. </p>
                        <p class="description">If you want to enjoy ice and snow in... </p>
                        <p class="read-more"><span>Read more</span></p>
                    </div>
                    <div class="content sm">
                        <p class="heading">Oshibori (sdxxdd) Fun! .... </p>
                        <p class="description">If you want to enjoy ice... </p>
                    </div>
                </a>
            </div>
            <div id="htmlcaption2">
                <a href="#">
                    <div class="content">
                        <p class="heading">Fun! Japan Reporter Recruitment </p>
                        <p class="description">Below is the hexadecimal representation for an array of HTML background
                            colors</p>
                        <p class="read-more"><span>Read more</span></p>
                    </div>
                    <div class="content sm">
                        <p class="heading">Fun! Japan Reporter ... </p>
                        <p class="description">Below is the hexadecimal...</p>
                    </div>
                </a>
            </div>
            <div id="htmlcaption3">
                <a href="#">
                    <div class="content">
                        <p class="heading">Fun! Japan Reporter Recruitment </p>
                        <p class="description">Below is the hexadecimal representation for an array of HTML background
                            colors</p>
                        <p class="read-more"><span>Read more</span></p>
                    </div>
                    <div class="content sm">
                        <p class="heading">Fun! Japan Reporter ... </p>
                        <p class="description">Below is the hexadecimal...</p>
                    </div>
                </a>
            </div>
        </div>
        <!-- EOF CAPTIONS -->

        <!-- THUMBNAIS -->
        <div id="banner-top-thumbs">
            <div class="thumb" style="background-image: url('assets/images/top/thumb_img_2.jpg');">
                <div class="thumb-content-wrapper">
                    <div class="thumb-content">
                        <p>We recruit people that can report...</p>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>
            <div class="thumb" style="background-image: url('assets/images/top/thumb_img_1.jpg');">
                <div class="thumb-content-wrapper">
                    <div class="thumb-content">
                        <p>We recruit people that can report...</p>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>
            <div class="thumb" style="background-image: url('assets/images/top/thumb_img_3.jpg');">
                <div class="thumb-content-wrapper">
                    <div class="thumb-content">
                        <p>We recruit people that can report...</p>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <!-- EOF THUMBNAIS -->
    </div>

    <!-- EOF SLIDER -->
    <div class="notification">
    </div>
    @include('layouts.includes.menu')
</header>
<!-- EOF Menu bars -->
<!-- EOF HEADER -->
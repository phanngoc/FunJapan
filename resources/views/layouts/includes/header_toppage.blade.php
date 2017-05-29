<!-- HEADER -->
<!-- Menu bars -->
<header class="global-header">
    <!-- Top header bar -->
    @include('layouts.includes._top_header_desktop')

    <!-- Top header bar mobile -->
    @include('layouts.includes._top_header_mobile')
    <!-- SLIDER -->
    @if (isset($banners) && count($banners))
        <div id="banner-top-sliderFrame">
        <!-- MAIN IMAGES -->
        <div id="banner-top-slider">
            @foreach($banners as $banner)
                <a class="lazyImage" href="{{ $banner->photo_urls['larger'] }}" title="#htmlcaption{{ $banner->id }}"></a>
            @endforeach
        </div>
        <!-- MAIN IMAGES -->
        <!-- CAPTIONS -->
        <div style="display: none;">
            @foreach($banners as $banner)
                <div id="htmlcaption{{ $banner->id }}">
                    <a href="{{ action('Web\ArticlesController@show', ['id' => $banner->articleLocale ? $banner->articleLocale->article_id : null]) }}">
                        <div class="content">
                            <p class="heading">{{ $banner->articleLocale ? $banner->articleLocale->getShortTitle() : '' }}</p>
                            <p class="description">{{ $banner->articleLocale ? $banner->articleLocale->getShortSummary() : '' }}</p>
                            <p class="read-more"><span>Read more</span></p>
                        </div>
                        <div class="content sm">
                            <p class="heading">{{ $banner->articleLocale ? $banner->articleLocale->getShortTitle() : '' }}</p>
                            <p class="description">{{ $banner->articleLocale ? $banner->articleLocale->getShortSummary() : '' }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <!-- EOF CAPTIONS -->

        <!-- THUMBNAIS -->
        <div id="banner-top-thumbs">
            @foreach($banners as $banner)
                <div class="thumb" style="background-image: url('{{ $banner->photo_urls['small'] }}');">
                    <div class="thumb-content-wrapper">
                        <div class="thumb-content">
                            <p>{{ $banner->articleLocale ? $banner->articleLocale->getShortTitle() : '' }}</p>
                        </div>
                    </div>
                    <div style="clear:both;"></div>
                </div>
            @endforeach
        </div>
        <!-- EOF THUMBNAIS -->
    </div>
    @endif

    <!-- EOF SLIDER -->
    @include('layouts.includes.menu')
</header>
<!-- EOF Menu bars -->
<!-- EOF HEADER -->
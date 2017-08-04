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
                        <div class="slider-summary">
                            <p class="slider-summary__title">{{ $banner->articleLocale ? $banner->articleLocale->getShortTitle() : '' }}</p>
                            <p class="slider-summary__description">{{ $banner->articleLocale ? $banner->articleLocale->getShortSummary() : '' }}</p>
                            <p class="slider-summary__read-more">
                                <span>
                                    more &nbsp;<i class="zmdi zmdi-more"></i>
                                </span>
                            </p>
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
                    <div class="thumb__layer"> </div>
                </div>
            @endforeach
        </div>
        <!-- EOF THUMBNAIS -->
    </div>
@endif
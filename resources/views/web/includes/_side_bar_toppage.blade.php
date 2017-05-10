<!-- SIDEBAR -->
<div class="sidebar-top">
    @if (isset($advertisementSrc))
        <div class="advertisement-br">
            <iframe src="{{ $advertisementSrc }}" scrolling="no"></iframe>
        </div>
    @endif
    @include('web.includes._popular_articles_series')
    @include('web.includes._popular_categories')
    @include('web.includes._footer')
</div>
<!-- EOF SIDEBAR -->

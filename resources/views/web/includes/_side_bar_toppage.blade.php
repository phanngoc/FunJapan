<!-- SIDEBAR -->
<div class="sidebar-top">
    @if (isset($advertisement))
        <div class="advertisement-br">
            <a target="_blank" href="{{ $advertisement->url }}">
                <img src="{{ $advertisement->photo_urls['normal'] }}">
            </a>
        </div>
    @endif
    {{-- @include('web.includes._popular_articles_series') --}}
    {{-- @include('web.includes._popular_categories') --}}
    @include('web.includes._footer')
</div>
<!-- EOF SIDEBAR -->

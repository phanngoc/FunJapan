<!-- POPULAR CATEGORIES -->
@if ($popularCategories->count() > 0)
    <div class="list-group-popular-category">
        <div class="list-group noborder">
            <div class="row">
                <div class="col-xs-12">
                    <div class="list-group-header">
                        <p class="list-group-title">POPULAR CATEGORIES <a href="#" class="show-more">show more</a></p>
                    </div>
                    @foreach ($popularCategories as $key => $category)
                        <div class="list-group-item @if ($key > 1) hidden-category hidden @endif">
                            <a href="{{ action('Web\CategoriesController@show', $category->name_link) }}">
                                <img src="{{ $category->photo_urls['normal'] }}" class="img-thumbnail">
                                <p class="text-right">{{ $category->name }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

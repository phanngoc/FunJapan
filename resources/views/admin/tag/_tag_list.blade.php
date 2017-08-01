@if (count($tags))
    @foreach ($tags as $tag)
        <div class="row">
            <div class="col-lg-2 text-center">
                <p class="p-md bg-success">{{ $tag->id }}</p>
                <p class="p-md bg-success">{{ $tag->created_at->format('d F Y g:i A') }}</p>
            </div>
            <div class="col-lg-8 text-center" id="edit-{{ $tag->id }}">
                <p class="p-xxs bg-success">{{ $tag->name }}</p>
                @foreach ($tag->tagLocales as $tagLocale)
                <p class="p-xxs bg-success">{{ $tagLocale->name }}</p>
                @endforeach
            </div>
            <div class="col-lg-1 text-center">
                <button class="p-md btn-primary btn edit" data-id="{{ $tag->id }}">{{ trans('admin/tag.button.modify') }}</button>
            </div>
            <div class="col-lg-1 text-center">
                <button class="p-md btn-primary btn delete" data-id="{{ $tag->id }}"
                    data-url="{{ action('Admin\TagsController@destroy') }}">{{ trans('admin/tag.button.delete') }}</button>
            </div>
        </div>
        <hr>
    @endforeach
    <div class="text-right">
        {!! $tags->appends(Request::except('page'))->links() !!}
    </div>
    <script type="text/javascript">
        var dataTags = {!! $tags->toJson() !!}
    </script>
@else
    @if (isset($isSearch))
        {{ trans('admin/tag.no_result') }}
    @else
        {{ trans('admin/tag.no_tag') }}
    @endif
@endif

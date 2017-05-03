@if ($postPhotos && $postPhotos->count() > 0)
    @foreach ($postPhotos as $postPhoto)
        @include('web.articles._single_post_photo', ['postPhoto' => $postPhoto])
    @endforeach
@else
    <p>{{ trans('web/post_photo.messages.no_photo') }}</p>
@endif

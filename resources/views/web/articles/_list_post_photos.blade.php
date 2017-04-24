@if ($postPhotos)
    @foreach ($postPhotos as $postPhoto)
        @include('web.articles._single_post_photo', ['postPhoto' => $postPhoto])
    @endforeach
@endif

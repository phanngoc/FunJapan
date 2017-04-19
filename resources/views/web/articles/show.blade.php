@extends('layouts/default_detail')

@section('content')
<div class="col-md-70 main-column">
    <!-- MAIN -->
    @if (!$errors->any() && !session()->has('message') && !session()->has('error'))
        @include('web.articles._detail', ['articleLocale' => $articleLocale])
    @endif
    <!-- EOF MAIN -->
</div>
@endsection

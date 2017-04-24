@extends('layouts/default_detail')

@section('style')
{{ Html::style('assets/admin/css/plugins/dropzone/dropzone.css') }}
@endsection

@section('content')
<div class="col-md-70 main-column">
    <!-- MAIN -->
    @if (!$errors->any() && !session()->has('message') && !session()->has('error'))
        @include('web.articles._detail', ['articleLocale' => $article->locale])
    @endif
    <!-- EOF MAIN -->
</div>
@endsection

<div id="alert-message">
    @foreach ($errors->all() as $message)
        <h2>{{ $message }}</h2>
    @endforeach
    @if (session()->has('message'))
        <h2>{!! session('message') !!}</h2>
    @endif
    @if (session()->has('error'))
        <h2>{{ session('error') }}</h2>
    @endif
</div>
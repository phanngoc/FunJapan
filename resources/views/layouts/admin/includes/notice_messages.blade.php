@if ($errors->any() || session()->has('message') || session()->has('error'))
    <div class="alert {{ session()->has('message') ? 'alert-success' : 'alert-danger' }}" id="alert-message">
        @foreach ($errors->all() as $message)
            <p>{{ $message }}</p>
        @endforeach
        @if (session()->has('message'))
            <p>{{ session('message') }}</p>
        @endif
        @if (session()->has('error'))
            <p>{{ session('error') }}</p>
        @endif
    </div>
@endif
<div id="alert-message">
</div>
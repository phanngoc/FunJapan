@extends('web.guide.layout_guide')

@section('content_child')
    <div>
        <h3>
            {{ trans('web/omikuji_user.omikuji') }}
        </h3>
        <div class="col-xs-8 col-xs-offset-2">
            <div class="text-center">
                <p>{{ trans('web/omikuji_user.updating') }}</p>
            </div>

        </div>

    </div>
@endsection

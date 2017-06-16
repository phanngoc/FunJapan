@extends('web.guide.layout_guide')

@section('content_child')
    <div>
        <h3>
            {{ trans('web/omikuji_user.omikuji') }}
        </h3>
        <div class="col-xs-8 col-xs-offset-2">
            <div class="text-center">
                <p><img src="{{ $omikujiItem->imageUrls['normal'] ?? '' }}" alt="" width="88px" height="171px"></p>
                @if($omikujiItem)
                    <p class="h1 text-center">
                        {{ trans('web/omikuji_user.mess_point',['point' => $omikujiItem->point]) }}
                    </p>
                @endif

                <p class="text-center"><a href="#">{{ trans('web/omikuji_user.get_fun') }}</a>
                    <br>
                    <br>
                    <a href="#" target="_blank">{{ trans('web/omikuji_user.win_free') }}</a>
                </p>

                <p class="text-center"><a href="#">{{ trans('web/omikuji_user.about_omikuji') }}</a></p>
            </div>

        </div>

    </div>
@endsection

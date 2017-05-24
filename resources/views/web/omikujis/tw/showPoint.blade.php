@extends('web.guide.layout_guide')

@section('content_child')
    <div>
        <h3>
            Omikuji
        </h3>
        <div class="col-xs-8 col-xs-offset-2">
            <div class="text-center">
                <p><img src="{{ $omikujiItem->imageUrls['normal'] ?? '' }}" alt="" width="235px" height="459px" style="width:20%; height:20%"></p>
                @if($omikujiItem)
                    <p class="h1 text-center">
                        {{ trans('web/omikuji_user.mess_point',['point' => $omikujiItem->point]) }}
                    </p>
                @endif

                <p class="text-center"><a href="#">Dapatkan Fun! Japan Point! Klik di sini!</a>
                    <br>
                    <br>
                    <a href="#" target="_blank">Win Free Japan trip!</a>
                </p>

                <p class="text-center"><a href="#">{{ trans('web/omikuji_user.about_omikuji') }}</a></p>
            </div>

        </div>

    </div>
@endsection

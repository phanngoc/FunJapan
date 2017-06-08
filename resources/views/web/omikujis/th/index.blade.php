@extends('web.guide.layout_guide')

@section('content_child')
    <div>
        <h3>
            Omikuji
        </h3>
        <div class="col-xs-8 col-xs-offset-2">
            <div class="text-center">
                <p><img src="{{ $omikuji->imageUrls['normal'] ?? '' }}" alt="" width="235" height="459" style="width:20%; height:20%"></p>
                {{ Form::open(['action' => ['Web\OmikujisController@create'], 'id' => 'omikuji-form', 'class' => 'form-horizontal', 'files' => true]) }}
                    {{ method_field('POST') }}
                    @if($remainingTime)
                        <p class="text-center">
                            {{ trans('web/omikuji_user.remainning_time',['time' => $remainingTime]) }}
                        </p>
                        <p class="text-center">
                            {{ Form::submit(trans('web/omikuji_user.button.submit'),['class' => 'btn btn-primary', 'disabled' => 'disabled']) }}
                        </p>
                    @else
                        <p class="text-center">
                            {{ Form::submit(trans('web/omikuji_user.button.submit'),['class' => 'btn btn-primary']) }}
                        </p>
                    @endif

                    <p class="text-center"><a href="#">{{ trans('web/omikuji_user.about_omikuji') }}</a></p>
                    {{ Form::hidden('omikujiId', $omikujiId) }}
                {{ Form::close() }}
            </div>

        </div>

    </div>
@endsection

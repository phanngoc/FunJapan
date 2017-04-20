@extends('layouts/default_login')
@section('content')
    <div class="top-body">
        <div class="main-content">
            <div class="row">
                <div class="main">
                    <div class="col-xs-offset-2 col-xs-8 text-center">
                        <div>
                            <h3>{{ trans('web/user.lost_password.title_requested') }}</h3>
                            <div tabindex="0" style="position: static; height: 0px; width: 0px; top: 0px; left: 0px;" id="ClickableArea"></div>
                            <div id="ContentWrapper">
                                <p>{{ trans('web/user.lost_password.description_requested') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

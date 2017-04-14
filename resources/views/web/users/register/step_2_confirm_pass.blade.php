@extends('layouts/default_register')

@section('content')
<div class="registration-body">
    <div class="step-2">
        {!! Form::open(['url' => action('Web\RegisterController@confirmPass')]) !!}
            <div class="form-group row has-feedback">
                <label for="email" class="col-md-18 col-form-label">Email<span class="require">*</span></label>
                <div class="col-md-82">
                    <input type="text" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
                </div>
                <input type="hidden" value="{{ $socialId }}" name="social_id" readonly>
                <input type="hidden" value="{{ $provider }}" name="provider" readonly>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row has-feedback">
                        <label for="password" class="col-md-36 col-form-label">Password<span class="require">*</span></label>
                        <div class="col-md-64">
                            <input class="form-control" id="password" name="password" placeholder="Minimum 6 letters" type="password" >
                            <label class="help-block">{{ $errors->has('password') ? $errors->first('password') : '' }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="step-btn-container">
                <input class="btn btn-primary" id="submit-button" type="submit" value="Next">
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

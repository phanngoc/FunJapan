@if (count($errors))
    <div class="validation-summary-errors panel panel-danger text-left">
        <div class="panel-heading">
            {{ trans('web/user.alert_show_error.title') }}
        </div>
        <div class="panel-body">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="white-space:pre-wrap;">{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
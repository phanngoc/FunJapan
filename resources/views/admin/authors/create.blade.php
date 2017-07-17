<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/author.add') }}</h2></div>
            <div class="ibox-content">
                <div class="row">
                    {{ Form::open([
                            'id' => 'author-form',
                            'class' => 'form-horizontal',
                            'files' => true,
                        ])
                    }}
                        @include('admin.authors._form')
                        <div class="form-group">
                            <div class="col-sm-1 col-sm-offset-2">
                                <a href="javascript:;" class="btn btn-primary" id="create-author"
                                    data-url="{{ action('Admin\AuthorsController@store') }}">
                                    {{ trans('admin/survey.button.save') }}
                                </a>
                            </div>
                        </div>
                    {{ Form::close() }}
                    <div id="redirect" data-url="{{ action('Admin\IdsController@index', ['currentTab' => 'author']) }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>
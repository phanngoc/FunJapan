@extends('layouts.admin.default')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h3>{{ trans('admin/article.edit_global') }}</h3>
            </div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\ArticlesController@updateGlobalInfo', $article->id],
                    'class' => 'form-horizontal', 'method' => 'POST']) }}
                    {{ Form::hidden('locale', $localeId) }}
                    <div class="form-group">
                        {{ Form::label(
                            'type',
                            trans('admin/article.label.type'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::select(
                                'type',
                                $types,
                                $article->type,
                                ['class' => 'form-control select-type'])
                            }}
                        </div>
                    </div>

                    <div class="form-group auto-approve-photo hidden">
                        {{ Form::label(
                            'auto_approve_photo',
                            trans('admin/article.label.auto_approve_photo'),
                            [
                                'class' => 'col-sm-2 control-label'
                            ]
                        ) }}
                        <div class="col-sm-10">
                            <label class="checkbox-inline">
                                {{ Form::checkbox(
                                    'auto_approve_photo',
                                    1,
                                    $article->auto_approve_photo
                                ) }}&nbsp;
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/article.button.update'), ['class' => 'btn btn-primary']) }}
                        </div>
                        <div class="col-sm-3">
                            <a class="btn btn-primary cancel" data-message="{{ trans('admin/article.cancel_message') }}"
                                href="{{ action('Admin\ArticlesController@show',
                                [$article->id, 'locale' => $localeId]) }}">
                                {{ trans('admin/article.button.cancel') }}
                            </a>
                        </div>
                    </div>
                {{ Form::close() }}
                <div id="infor" data-type-photo="{!! config('article.type.photo') !!}"
                    data-type-campaign="{!! config('article.type.campaign') !!}"
                    data-type-coupon="{!! config('article.type.coupon') !!}"
                    data-place-holder="{!! trans('admin/article.select_category') !!}"
                    data-url-ajax="{!! action('Admin\ArticlesController@getCategoryLocale') !!}">
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/article.js') !!}
@stop

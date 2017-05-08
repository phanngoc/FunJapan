@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/article.set_language') }}</h2></div>
                <div class="ibox-content">
                    {{ Form::open([
                        'action' => ['Admin\ArticlesController@updateOtherLanguage', $article->id],
                        'id' => 'create-article-form',
                        'class' => 'form-horizontal',
                        'files' => true])
                    }}
                    <div class="form-group">
                        {{ Form::label(
                            'locale',
                            trans('admin/article.label.locale'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::select(
                                'locale',
                                $locales,
                                null,
                                ['class' => 'form-control'])
                            }}
                        </div>
                    </div>

                    {{ Form::hidden('type', $article->type) }}

                    {{ Form::hidden('category', $article->category_id) }}

                    <div class="form-group required">
                        {{ Form::label(
                            'thumbnail',
                            trans('admin/article.label.thumbnail'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt5">
                            {{ Form::file(
                                'thumbnail',
                                null,
                                ['class' => 'form-control'])
                            }}
                        </div>
                    </div>

                    @include('admin.elements._article_inputs_form')

                    <div class="form-group">
                        {{ Form::label(
                            'tags',
                            trans('admin/article.label.tags'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::select(
                                'tags[]',
                                old('tags') ? array_flip(old('tags')) : [],
                                null,
                                [
                                    'class' => 'form-control article-tag',
                                    'multiple' => 'multiple',
                                    'data-url' => action('Admin\TagsController@suggest')
                                ])
                            }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'publish_date',
                            trans('admin/article.label.publish_date'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 width30">
                            {{ Form::text(
                                'publish_date',
                                null,
                                ['class' => 'form-control datetime-picker'])
                            }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'is_top_article',
                            trans('admin/article.label.is_top'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            <label class="checkbox-inline">
                                {{ Form::checkbox(
                                    'is_top_article',
                                    1,
                                    false)
                                }}&nbsp;
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'is_alway_hide',
                            trans('admin/article.label.is_alway_hide'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            <label class="checkbox-inline">
                                {{ Form::checkbox(
                                    'is_alway_hide',
                                    1,
                                    false)
                                }}&nbsp;
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'is_member_only',
                            trans('admin/article.label.is_member_only'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            <label class="checkbox-inline">
                                {{ Form::checkbox(
                                    'is_member_only',
                                    1,
                                    false)
                                }}&nbsp;
                            </label>
                        </div>
                    </div>


                    <div class="date-time-campaign
                        @if ($article->type == config('article.type.normal'))
                            hidden
                        @endif">
                        <div class="form-group">
                            {{ Form::label(
                                'time_campaign',
                                trans('admin/article.label.time_campaign'),
                                [
                                    'class' => 'col-sm-2 control-label',
                                ]
                            ) }}
                            <div class="col-sm-5 width30">
                                {{ Form::text(
                                    'start_campaign',
                                    null,
                                    ['class' => 'form-control datetime-picker'])
                                }}
                            </div>
                            <div class="col-sm-5 width30">
                                {{ Form::text(
                                    'end_campaign',
                                    null,
                                    ['class' => 'form-control datetime-picker'])
                                }}
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/article.button.add'), ['class' => 'btn btn-primary']) }}
                        </div>

                        <div class="col-sm-3">
                            <a class="btn btn-primary" href="{{ action('Admin\ArticlesController@index') }}">
                                {{ trans('admin/article.button.cancel') }}
                            </a>
                        </div>
                    </div>
                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/article.js') !!}
@stop
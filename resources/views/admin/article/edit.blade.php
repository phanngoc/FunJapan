@extends('layouts.admin.default')

@section('style')
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h3>{{ trans('admin/article.edit_article') }}</h3>
            </div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\ArticlesController@update', $article->id], 'id' => 'create-article-form', 'class' => 'form-horizontal', 'files' => true]) }}
                    {{ method_field('PUT') }}
                    @include('admin.elements._article_inputs_form',
                        [
                            'title' => $articleLocale->title,
                            'content' => $articleLocale->content,
                            'summary' => $articleLocale->summary,
                        ])

                    <div class="form-group required">
                        {{ Form::label(
                            'category',
                            trans('admin/article.label.category'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::select(
                                'category',
                                $categories,
                                $article->category_id,
                                ['class' => 'form-control', 'required'])
                            }}
                        </div>
                    </div>


                    <div class="form-group">
                        {{ Form::label(
                            'tags',
                            trans('admin/article.label.tags'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::select(
                                'tags[]',
                                $tags,
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
                            {{ Form::date(
                                'publish_date',
                                $articleLocale->published_at,
                                ['class' => 'form-control'])
                            }}
                        </div>
                    </div>

                    <div class="form-group">
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
                                    $articleLocale->is_top_article)
                                }}&nbsp;
                            </label>
                        </div>
                    </div>

                    <div class="date-time-campaign">
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
                                    $articleLocale->start_campaign,
                                    [
                                        'class' => 'form-control datetime-picker',
                                        'placeholder' => trans('admin/article.placeholder.start_time'),
                                    ]
                                ) }}
                            </div>
                            <div class="col-sm-5 width30">
                                {{ Form::text(
                                    'end_campaign',
                                    $articleLocale->end_campaign,
                                    [
                                        'class' => 'form-control datetime-picker',
                                        'placeholder' => trans('admin/article.placeholder.start_time'),
                                    ]
                                ) }}
                            </div>
                        </div>
                    </div>

                    {{ Form::hidden('locale', $localeId) }}
                    {{ Form::hidden('articleLocaleId', $articleLocale->id) }}

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/article.button.update'), ['class' => 'btn btn-primary']) }}
                        </div>
                        <div class="col-sm-3">
                            <a class="btn btn-primary" href="{{ action('Admin\ArticlesController@show',
                                [$articleLocale->article_id, 'locale' => $localeId]) }}">
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
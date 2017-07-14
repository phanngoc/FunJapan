@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading border-left">
        <div class="col-lg-10 page-title">
            <h2><b>{{ trans('admin/article.label.article') }}</b> {{ trans('admin/article.label.list') }}</h2>
            <ol class="breadcrumb">
                <li class="home">
                    <a href="{{ action('Admin\DashboardController@index') }}"><i class="fa fa-home"></i> <b>{{ trans('admin/article.label.home') }}</b></a>
                </li>
                <li>
                    <b>{{ trans('admin/article.article_list') }}</b></a>
                </li>
                <li class="active breadcrumb-preview">
                    <strong>
                        {{ trans('admin/article.label.edit') }}
                    </strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ trans('admin/article.label.country') }}</th>
                                    <th>{{ trans('admin/article.label.published_at') }}</th>
                                    <th>{{ trans('admin/article.label.title') }}</th>
                                    <th>{{ trans('admin/article.label.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if ($article->articleLocales->count() > 0)
                                @foreach ($article->articleLocales as $articleLocale)
                                    <tr>
                                        <td>{{ $articleLocale->locale->name }} ({{ strtoupper($articleLocale->locale->iso_code) }})</td>
                                        <td>{{ $articleLocale->published_at->format('d F Y g:i A') }}</td>
                                        <td>{{ $articleLocale->title }}</td>
                                        <td class="article-detail-action"
                                            data-url="{{ action('Admin\ArticlesController@stopOrStart') }}"
                                            data-article-locale="{{ $articleLocale->id }}"
                                            data-start-confirm="hihihihi"
                                            data-start-label="{{ trans('admin/article.button.start') }}"
                                            data-published-label="{{ trans('admin/article.status_by_locale.published') }}"
                                            data-stop-confirm="blabla"
                                            data-stop-label="{{ trans('admin/article.button.stop') }}">
                                            <button type="button" class="btn btn-default btn-xs btn-w-m
                                                btn-label-{{ array_flip(config('article.status_by_locale'))[$articleLocale->status_by_locale] }}">
                                                <i class="fa fa-level-up"></i>
                                                {{ trans('admin/article.status_by_locale.' . array_flip(config('article.status_by_locale'))[$articleLocale->status_by_locale]) }}
                                            </button>
                                            <a type="button" href="{{ action('Admin\ArticlesController@edit', $articleLocale->id) }}"
                                                class="btn btn-default btn-xs btn-w-m btn-modify">
                                                <i class="fa fa-pencil"></i> {{ trans('admin/article.button.modify') }}
                                            </a>
                                            @if ($articleLocale->status_by_locale == config('article.status_by_locale.published'))
                                                <button type="button" class="btn btn-default btn-xs btn-w-m btn-stop">
                                                    <i class="fa fa-stop"></i> {{ trans('admin/article.button.stop') }}
                                                </button>
                                            @elseif ($articleLocale->status_by_locale == config('article.status_by_locale.schedule'))
                                                <button type="button" class="btn btn-default btn-xs btn-w-m btn-stop">
                                                    <i class="fa fa-stop"></i> {{ trans('admin/article.button.stop') }}
                                                </button>
                                            @elseif ($articleLocale->status_by_locale == config('article.status_by_locale.stop'))
                                                <button type="button" class="btn btn-default btn-xs btn-w-m btn-start">
                                                    <i class="fa fa-chevron-circle-right"></i> {{ trans('admin/article.button.start') }}
                                                </button>
                                            @elseif ($articleLocale->status_by_locale == config('article.status_by_locale.draft'))
                                                <button type="button" class="btn btn-default btn-xs btn-w-m btn-start" disabled>
                                                    <i class="fa fa-chevron-circle-right"></i> {{ trans('admin/article.button.start') }}
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($localesNoArticles->count() > 0)
                                    @foreach ($localesNoArticles as $localeNoArticles)
                                        <tr class="faint-word">
                                            <td>{{ $localeNoArticles->name }} ({{ strtoupper($localeNoArticles->iso_code) }})</td>
                                            <td>{{ trans('admin/article.label.none') }}</td>
                                            <td>{{ trans('admin/article.label.none') }}</td>
                                            <td class="article-detail-action">
                                                <button type="button" class="btn btn-default btn-xs btn-w-m btn-label-null">
                                                    <i class="fa fa-file-o"></i> {{ trans('admin/article.button.null') }}
                                                </button>
                                                <a type="button"
                                                    href="{{ action('Admin\ArticlesController@create', ['localeId' => $localeNoArticles->id, 'articleId' => $article->id]) }}"
                                                    class="btn btn-default btn-xs btn-w-m btn-create">
                                                    <i class="fa fa-pencil"></i> {{ trans('admin/article.button.create') }}
                                                </a>
                                                <button type="button" class="btn btn-default btn-xs btn-w-m btn-start" disabled>
                                                    <i class="fa fa-chevron-circle-right"></i> {{ trans('admin/article.button.start') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @else
                                <tr>
                                    <td colspan="4">
                                        <span class="label label-warning">{{ trans('admin/article.label.no_article') }}</span>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="ibox-content no-borders">
                            <div class="row pull-right label-explain">
                                <p><span class="label label-custom-published text-uppercase"></span> {{ trans('admin/article.status_by_locale.published') }}</p>
                                <p><span class="label label-custom-schedule text-uppercase"></span> {{ trans('admin/article.status_by_locale.schedule') }}</p>
                                <p><span class="label label-custom-draft text-uppercase"></span> {{ trans('admin/article.status_by_locale.draft') }}</p>
                                <p><span class="label label-custom-stop text-uppercase"></span> {{ trans('admin/article.status_by_locale.stop') }}</p>
                                <p><span class="label label-custom-no-article text-uppercase"></span> {{ trans('admin/article.status_by_locale.no_article') }}</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(function () {
            $('.article-detail-action').on('click', '.btn-start, .btn-stop', function () {
                var element = $(this);
                var articleLocaleId = element.parents('.article-detail-action').attr('data-article-locale');
                var url = element.parents('.article-detail-action').attr('data-url');

                if (element.hasClass('btn-stop')) {
                    var titleConfirm = element.parents('.article-detail-action').attr('data-stop-confirm');
                } else {
                    var titleConfirm = element.parents('.article-detail-action').attr('data-start-confirm');
                }

                swal({
                    title: titleConfirm,
                    text: '',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'yes',
                    cancelButtonText: 'cancel',
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: 'GET',
                            url: url,
                            data: {
                                'articleLocaleId': articleLocaleId
                            },
                            success: (response) => {
                                if (response.success) {
                                    swal(response.message, '', 'success');
                                    if (element.hasClass('btn-stop')) {
                                        var textBtn = '<i class="fa fa-chevron-circle-right"></i> ';
                                        textBtn += element.parents('.article-detail-action').attr('data-start-label');
                                        element.removeClass('btn-stop').addClass('btn-start').html(textBtn);
                                        var textLabel = '<i class="fa fa-level-up"></i> ';
                                        textLabel += element.parents('.article-detail-action').attr('data-stop-label');
                                        element.parents('.article-detail-action').find('.btn:first').removeClass()
                                            .addClass('btn btn-default btn-xs btn-w-m btn-label-stop').html(textLabel);
                                    } else {
                                        var textBtn = '<i class="fa fa-stop"></i> ';
                                        textBtn += element.parents('.article-detail-action').attr('data-stop-label');
                                        element.removeClass('btn-start').addClass('btn-stop').html(textBtn);
                                        var textLabel = '<i class="fa fa-level-up"></i> ';
                                        textLabel += element.parents('.article-detail-action').attr('data-published-label');
                                        element.parents('.article-detail-action').find('.btn:first').removeClass()
                                            .addClass('btn btn-default btn-xs btn-w-m btn-label-published').html(textLabel);
                                    }
                                } else {
                                    swal(response.message, '', 'error');
                                }

                            },
                            error: function (e) {
                            }
                        });
                    }
                });
            });
        });
    </script>
@stop

@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/article_rank.title') }}</h2></div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs rank-tabs">
                            @foreach ($locales as $key => $locale)
                                <li class="{{ $key == 1 ? 'active' : '' }}" data-tab="{{ $key }}">
                                    <a data-toggle="tab" href="#{{ $key }}">{{ $locale }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach ($articleRanks as $localeId => $articleRank)
                                <div id="{{ $localeId }}" class="tab-pane {{ $localeId == 1 ? 'active' : '' }}">
                                    @foreach (config('article.rank') as $rank)
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-2 col-sm-2 col-xs-2">
                                                    <label class="btn btn-primary btn-md">Rank {{ $rank }}</label>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-8">
                                                    <select
                                                        class="choose-article-{{$localeId}} article-select2"
                                                        style="width: 100%;"
                                                        data-rank="{{ $rank }}"
                                                        data-locale-id="{{ $localeId }}">
                                                        @if (count($articleRank))
                                                            @foreach($articleRank as $ar)
                                                                @if($ar->rank == $rank)
                                                                    <option value="{{$ar->article_locale_id}}" selected>
                                                                        {{ $ar['articleLocale']->title }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                <p id="error-{{$rank}}-{{$localeId}}" class="text-danger font-bold m-xxs"></p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <button class="btn btn-primary margin-top-10 update-banner-all"
                                        id="save-ranks-{{$localeId}}"
                                        type="button"
                                        disabled="disabled">
                                        <i class="fa fa-spinner fa-pulse fa-fw hidden"></i>
                                        <i class="fa fa-check"></i>&nbsp;
                                        <strong>{{ trans('admin/banner.label_update_all') }}</strong>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        var perPage = {{ config('article.per_page') }};
        var labelUpdateSuccess = "{{ trans('admin/article.update_success') }}";
    </script>
    {{ Html::script('assets/admin/js/article_rank.js') }}
@endsection
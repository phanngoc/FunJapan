<header>
    <ul class="detail-breadcrumbs">
        <li>
            <a href="#">
                <i class="fa fa-home" aria-hidden="true"></i> {{ trans('web/global.title', ['article_title' => '']) }}
            </a>
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </li>
        <li>
            <a href="#">{{ $articleLocale->article->category->name }}</a> <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </li>
        <li>
            <a href="{{ action('Web\ArticlesController@show', [$articleLocale->article_id]) }}">
                {{ isset($articleLocale->title) ? $articleLocale->title : '' }}
            </a>
        </li>
    </ul>
    <p class="article-detail-category">{{ $articleLocale->article->category->name }}</p>
    <p class="article-detail-title">{{ isset($articleLocale->title) ? $articleLocale->title : '' }}</h1>
</header>

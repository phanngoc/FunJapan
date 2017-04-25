<tr data-id="{{ $articleLocale->id }}">
    <td>
        <a href="{{ action('Web\ArticlesController@show', $articleLocale->article_id) }}" target="_blank">
            {{ $articleLocale->title }}
        </a>
    </td>
    <td>{{ $articleLocale->published_at }}</td>
    <td>
        <a href="javascript:;" class="remove-recommended-article"
            data-id="{{ $articleLocale->id }}"
            data-url="{{ action('Admin\RecommendedArticlesController@destroy', $articleLocale->id) }}"
            data-title-confirm="{{ trans('admin/recommend_article.messages.confirm_title') }}"
            data-message-confirm="{{ trans('admin/recommend_article.messages.confirm_remove') }}"
            data-yes-confirm="{{ trans('admin/recommend_article.button.yes') }}"
            data-no-confirm="{{ trans('admin/recommend_article.button.no') }}"
        >
            <i class="fa fa-times-circle text-danger"></i>
        </a>
    </td>
</tr>

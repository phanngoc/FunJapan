<tr data-id="{{ $articleLocale->id }}">
    <td>
        <a href="{{ action('Web\ArticlesController@show', $articleLocale->article_id) }}" target="_blank">
            {{ $articleLocale->title }}
        </a>
    </td>
    <td>{{ $articleLocale->published_at }}</td>
    <td>
        <a href="javascript:;" class="remove-popular-article"
            data-article-locale-id="{{ $articleLocale->id }}"
            data-url="{{ action('Admin\PopularArticlesController@destroy', $articleLocale->id) }}"
        >
            <i class="fa fa-times-circle text-danger"></i>
        </a>
    </td>
</tr>

<thead>
    <tr>
        <th class="text-center col-sm-1 sort" data-sort-name="id">{{ trans('admin/author.label.id') }}</th>
        <th class="text-center col-sm-2">{{ trans('admin/author.label.photo') }}</th>
        <th class="text-center col-sm-3 sort" data-sort-name="name">{{ trans('admin/author.label.name') }}</th>
        <th class="text-center col-sm-3">{{ trans('admin/author.label.description') }}</th>
        <th class="text-center col-sm-3">{{ trans('admin/author.label.action') }}</th>
    </tr>
</thead>
<tbody>
    @if (count($authors) > 0)
        @foreach($authors as $author)
            <tr data-id="{{ $author->id }}">
                <td class="text-center author-id">{{ $author->id }}</td>
                <td class="text-center author-photo">
                    <img src="{{ $author->photoUrl['small']}}"
                        id="preview"
                        {{ (!$author->photoUrl['small']) ? 'style=display:none;' : '' }}>
                </td>
                <td class="author-name">{{ $author->name }}</td>
                <td class="author-description">{{ $author->description ?? ''}}</td>
                <td class="text-center action">
                    <a class="btn btn-info edit-author" href="javascript:;">
                        <i class="fa fa-pencil"></i>&nbsp;{{ trans('admin/article.button.edit') }}
                    </a>
                    <a class="btn btn-primary" href="{{ action('Admin\AuthorsController@show', $author->id) }}">
                        <i class="fa fa-list"></i>&nbsp;{{ trans('admin/client.label.article_list') }}
                    </a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5" class="text-center">
                <span>{{ trans('admin/client.no_matching') }}</span>
            </td>
        </tr>
    @endif
</tbody>
{!! Form::hidden('sortBy', $filter['sortBy'] ?? null) !!}

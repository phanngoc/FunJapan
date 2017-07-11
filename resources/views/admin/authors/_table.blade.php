<thead>
    <tr>
        <th style="min-width: 100px;" class="text-center sort" data-sort-name="id">{{ trans('admin/author.label.id') }}</th>
        <th style="min-width: 100px;" class="text-center">{{ trans('admin/author.label.photo') }}</th>
        <th style="min-width: 300px;" class="text-center sort" data-sort-name="name">{{ trans('admin/author.label.name') }}</th>
        <th style="min-width: 300px;" class="text-center">{{ trans('admin/author.label.description') }}</th>
        <th style="min-width: 300px;" class="text-center">{{ trans('admin/author.label.action') }}</th>
    </tr>
</thead>
<tbody>
    @if (count($clients) > 0)
        @foreach($authors as $author)
            <tr data-id="{{ $author->id }}">
                <td class="text-center author-id">{{ $author->id }}</td>
                <td class="text-center author-photo">
                    <img src="{{ $author->photoUrl['small']}}" id="preview">
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

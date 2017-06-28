<thead>
    <tr>
        <th style="min-width: 100px;" class="text-center sort" data-sort-name="id">
            {{ trans('admin/client.label.id') }}
        </th>
        <th style="min-width: 500px;" class="text-center sort" data-sort-name="name">
            {{ trans('admin/client.label.name') }}
        </th>
        <th style="min-width: 300px;" class="text-center">{{ trans('admin/client.label.action') }}</th>
    </tr>
</thead>
<tbody>
    @if (count($clients) > 0)
        @foreach($clients as $client)
            <tr>
                <td class="text-center">{{ $client->id }}</td>
                <td class="client-name" data-id="{{$client->id}}">{{ $client->name }}</td>
                <td class="text-center action">
                    <a class="btn btn-info edit-client" href="javascript:;">
                        <i class="fa fa-pencil"></i>&nbsp;{{ trans('admin/article.button.edit') }}
                    </a>
                    <a class="btn btn-primary" href="{{ action('Admin\ClientsController@show', $client->id) }}">
                        <i class="fa fa-list"></i>&nbsp;{{ trans('admin/client.label.article_list') }}
                    </a>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="3" class="text-center">
                <span>{{ trans('admin/client.no_matching') }}</span>
            </td>
        </tr>
    @endif
</tbody>
{!! Form::hidden('sortBy', $filter['sortBy'] ?? null) !!}
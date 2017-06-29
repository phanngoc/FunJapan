<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content ibox-result">
                <table class="table table-striped table-hover">
                    <tbody id="sortable">
                        @forelse($results as $key => $result)
                            <tr>
                                <td>
                                    <a href="javascript:;" onclick="showDetail({{$result->id}})">
                                        {{ $key + 1 }} - {{ $result->title }}
                                    </a>
                                    <div class="pull-right">
                                        <a data-toggle="tooltip" data-placement="left" title="Edit" href="{{ action('Admin\ResultsController@edit', [$survey->id, $result->id]) }}" class="edit">
                                            &nbsp;<i class="fa fa-pencil-square-o fa-lg"></i>
                                        </a>
                                        <a data-toggle="tooltip" data-placement="top" title="Delete" href="javascript:;" data-url="{{ action('Admin\ResultsController@destroy', [$survey->id, $result->id]) }}" class="delete">
                                            &nbsp;<i class="fa fa-trash-o fa-lg"></i>
                                        </a>
                                    </div>
                                    <div class="show-detail-{{$result->id}}" style="display: none;">
                                        <p class="text-center">
                                            <strong>Score: </strong>
                                            {{ ($result->required_point_from != 0) ? $result->required_point_from : '' }}
                                            {{ ($result->required_point_from != 0 && $result->required_point_to != 0) ? ' - ' : ''}}
                                            {{ ($result->required_point_to != 0) ?  $result->required_point_to : '' }}
                                        </p>
                                        <p class="text-center"><img src="{{ $result->photoUrl['small'] }}"></p>
                                        <div class="text-center">
                                            {!! $result->html_description !!}
                                        </div>
                                        <p class="text-center">{{ $result->bottom_text }}</p>
                                    </div>
                                </td>
                            <tr>
                        @empty
                            <span class="show-nothing">{{ trans('admin/result.show_nothing') }}</span>
                        @endforelse
                    </tbody>
                </table>
             </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/question.question') }}</h2></div>
            <div class="ibox-content">
                <table class="table table-striped table-hover">
                    <tbody id="sortable">
                        @forelse($questions as $key => $question)
                            <tr id="order_{{ $question->id }}">
                                <td>
                                    <a href="javascript:;" onclick="showOption({{$question->id}})">
                                        {{ $key + 1 }} - {{ $question->title }}
                                    </a>
                                    <div class="pull-right">
                                        <a data-toggle="tooltip" data-placement="left" title="Edit" href="{{ action('Admin\QuestionsController@edit', [$survey->id, $question->id]) }}" class="edit">
                                            &nbsp;<i class="fa fa-pencil-square-o fa-lg"></i>
                                        </a>
                                        <a data-toggle="tooltip" data-placement="top" title="Delete" href="javascript:;" data-url="{{ action('Admin\QuestionsController@destroy', [$survey->id, $question->id]) }}" class="delete">
                                            &nbsp;<i class="fa fa-trash-o fa-lg"></i>
                                        </a>
                                    </div>
                                    <div class="show-option-{{$question->id}}" style="display: none;">
                                        @if($question->question_type == config('question.type_value.checkbox'))
                                            @foreach($question->option_name as $key => $value)
                                                <p class="list-option">
                                                    <input type="checkbox" id="{{ $key }}" disabled="" />
                                                    <span>{{ $value }}</span>
                                                </p>
                                            @endforeach
                                        @elseif ($question->question_type == config('question.type_value.radio'))
                                            @foreach($question->option_name as $key => $value)
                                                <p class="list-option">
                                                    <input type="radio" id="{{ $key }}" disabled="" />
                                                    <span>{{ $value }}</span>
                                                </p>
                                            @endforeach
                                        @else
                                            <p class="list-option">
                                                {{ trans('admin/question.text') }}
                                            </p>
                                        @endif
                                    </div>
                                </td>
                            <tr>
                        @empty
                            <span class="show-nothing">{{ trans('admin/question.show_nothing') }}</span>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    <button data-url="{{ action('Admin\QuestionsController@updateOrder') }}" id="update-order" class="btn btn-primary hidden">
                        {{ trans('admin/menu.update_position') }}
                    </button>
                </div>
                <div id="delete-confirm" data-confirm-message="{{ trans('admin/question.delete_confirm') }}"></div>
                <div id="url-redirect" data-url="{{ url()->current() }}"></div>
            </div>
        </div>
    </div>
</div>

{{ Form::open(['id' => 'update-order-form']) }}
    {{ method_field('POST') }}
{{ Form::close() }}

@section('script')
    {!! Html::script('assets/admin/js/question.js') !!}
    <script type="text/javascript">
        function showOption(id) {
            $('.show-option-' + id).slideToggle();
        }
    </script>
@stop
<div class="form-group required">
    {{ Form::label(
        'title',
        trans('admin/question.question'),
        ['class' => 'col-sm-1 control-label'])
    }}
    <div class="col-sm-9">
        {{ Form::text(
            'title',
            $question->title ?: '',
            [
                'class' => 'form-control',
                'required',
            ])
        }}
    </div>
</div>
@if(isset($question->option_name))
    @foreach ($question->option_name as $key => $value)
        <div class="form-group option-edit">
            {{ Form::label(
                'option',
                trans('admin/question.option'),
                ['class' => 'col-sm-1 control-label'])
            }}
            <div class="col-sm-9">
                {{ Form::text(
                    'option_name[]',
                    $value ?: '',
                    [
                        'class' => 'form-control',
                        'required',
                    ])
                }}
            </div>
        </div>
    @endforeach
@endif
<div class="form-question">
    <div class="form-group">
        {{ Form::label(
            'type',
            trans('admin/question.type'),
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-9">
            {{ Form::select(
                'question_type',
                config('question.type'),
                $question->question_type ?? null,
                [
                    'class' => 'form-control question-type',
                    'required',
                ])
            }}
        </div>
    </div>
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
                    'class' => 'form-control title',
                    'required',
                ])
            }}
        </div>
    </div>
    @if(isset($question->option_name))
        @foreach ($question->option_name as $key => $value)
            <div class="form-group input-option">
                {{ Form::label(
                    'option',
                    trans('admin/question.option'),
                    ['class' => 'col-sm-1 control-label'])
                }}
                <div class="col-sm-4">
                    {{ Form::text(
                        'option_name[]',
                        $value ?: '',
                        [
                            'class' => 'form-control',
                            'required',
                        ])
                    }}
                </div>
                {{ Form::label(
                    'option',
                    trans('admin/question.option'),
                    ['class' => 'col-sm-1 control-label'])
                }}
                <div class="col-sm-4">
                    {{ Form::text(
                        'score[]',
                        $question->score[$key] ?: '',
                        [
                            'class' => 'form-control',
                            'required',
                        ])
                    }}
                </div>
                <div class="col-sm-2">
                    <a class="add-option"><i class="fa fa-plus-square-o fa-lg"></i></a>
                    <a class="delete-option"><i class="fa fa-trash fa-lg"></i></a>
                </div>
            </div>
        @endforeach
        <div class="form-group other-option">
            {{ Form::label(
                'option',
                trans('admin/question.other_option'),
                ['class' => 'col-sm-1 control-label'])
            }}
            <div class="col-sm-9">
                {{ Form::checkbox(
                    'other_option',
                    1,
                    $question->other_option ?? 0)
                }}
            </div>
        </div>
    @endif
</div>
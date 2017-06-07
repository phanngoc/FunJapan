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
                null,
                [
                    'class' => 'form-control question-type',
                    'required',
                ])
            }}
        </div>
    </div>
    <div class="form-group required question">
        {{ Form::label(
            'title',
            trans('admin/question.question'),
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-9">
            {{ Form::text(
                'title',
                '',
                [
                    'class' => 'score form-control title',
                    'required',
                ])
            }}
        </div>
    </div>
    <p class="text-danger font-bold error-question"></p>
</div>
<div id="statusForm" data-status=""></div>
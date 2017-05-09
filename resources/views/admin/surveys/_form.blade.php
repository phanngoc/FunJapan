<div class="form-group required">
    {{ Form::label(
        'title',
        trans('admin/survey.title'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10">
        {{ Form::text(
            'title',
            $survey->title ?? '',
            [
                'class' => 'form-control',
                'required',
            ])
        }}
    </div>
</div>
<div class="form-group">
    {{ Form::label(
        'title',
        trans('admin/survey.description'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10">
        {{ Form::textarea(
            'description',
            $survey->description ?? '',
            [
                'class' => 'article-content',
            ])
        }}
    </div>
</div>
<div class="form-group">
    {{ Form::label(
        'type',
        trans('admin/survey.type'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10">
        {{ Form::select(
            'type',
            config('survey.type'),
            $survey->type ?? null,
            [
                'class' => 'form-control',
                'required',
            ])
        }}
    </div>
</div>
<div class="form-group">
    {{ Form::label(
        'point',
        trans('admin/survey.point'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10">
        {{ Form::text(
            'point',
            $survey->point ?? '',
            [
                'class' => 'form-control',
            ])
        }}
    </div>
</div>
<div class="form-group">
    {{ Form::label(
        'locale',
        trans('admin/survey.language'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10">
        {{ Form::select(
            'locale',
            $locales,
            $survey->locale_id ?? null,
            [
                'class' => 'form-control',
                'required',
            ])
        }}
    </div>
</div>
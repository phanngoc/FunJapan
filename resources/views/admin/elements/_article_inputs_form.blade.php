
<div class="form-group required">
    {{ Form::label(
        'title',
        trans('admin/article.label.title'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10">
        {{ Form::text(
            'title',
            $title ?? '',
            [
                'class' => 'form-control',
                'placeholder' => trans('admin/article.placeholder.title'),
                'required',
            ])
        }}
    </div>
</div>

<div class="form-group required">
    {{ Form::label(
        'summary',
        trans('admin/article.label.summary'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10">
        {{ Form::textarea(
            'summary',
            $summary ?? '',
            [
                'class' => 'form-control',
                'rows' => 2,
                'required',
            ])
        }}
    </div>
</div>

<div class="form-group required">
    {{ Form::label(
        'content',
        trans('admin/article.label.content'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10">
        {{ Form::textarea(
            'content',
            $content ?? '',
            [
                'class' => 'article-content',
                'placeholder' => trans('admin/article.placeholder.content'),
                'required',
            ])
        }}
    </div>
</div>

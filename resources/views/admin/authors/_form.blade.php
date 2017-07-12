<div class="form-group required">
    {{ Form::label(
        'name',
        trans('admin/author.label.name'),
        ['class' => 'col-sm-1 control-label'])
    }}
    <div class="col-sm-9">
        {{ Form::text(
            'name',
            $author->name ?? null,
            [
                'class' => 'form-control',
                'required',
            ])
        }}
        <p class="text-danger font-bold error-author-name"></p>
    </div>
</div>
<div class="form-group">
    {{ Form::label(
        'name',
        trans('admin/author.label.photo'),
        ['class' => 'col-sm-1 control-label'])
    }}
    <div class="col-sm-9">
        {{ Form::file(
            'photo',
            [
                'accept' => 'image/jpeg,image/png,image/jpg',
                'id' => 'photo',
            ])
        }}
        <p class="text-danger font-bold error-author-photo"></p>
    </div>
</div>
<div class="form-group" id="preview-section" style="display: none;">
    <div class="col-sm-4 col-sm-offset-1">
        <img src="#" id="preview-img" data-url="">
    </div>
</div>

<div class="form-group">
    {{ Form::label(
        'name',
        trans('admin/author.label.description'),
        ['class' => 'col-sm-1 control-label'])
    }}
    <div class="col-sm-9">
        {{ Form::text(
            'description',
            $author->description ?? null,
            [
                'class' => 'form-control',
            ])
        }}
        <p class="text-danger font-bold error-author-description"></p>
    </div>
</div>
<input type="hidden" value="{{ $author->id ?? null }}" name="id">

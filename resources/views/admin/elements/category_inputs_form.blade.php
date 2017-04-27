<div class="form-group">
    {{ Form::label(
        'name',
        trans('admin/category.label.name'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10">
        {{ Form::text(
            'name',
            $category->name ?? '',
            [
                'class' => 'form-control',
                'placeholder' => trans('admin/category.placeholder.name')
            ])
        }}
    </div>
</div>
<div class="form-group">
    {{ Form::label(
        'short_name',
        trans('admin/category.label.short_name'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10">
        {{ Form::text(
            'short_name',
            $category->short_name ?? '',
            [
                'class' => 'form-control',
                'placeholder' => trans('admin/category.placeholder.short_name')
            ])
        }}
    </div>
</div>
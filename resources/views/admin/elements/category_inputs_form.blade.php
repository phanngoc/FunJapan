<div id="imageMimes" data-mimes="{{ config('images.validate.category_icon.mimes') }}"
    data-message="{{ trans('admin/category.icon_message',['type' => config('images.validate.category_icon.mimes')]) }}"
    data-message-size="{{ trans('admin/category.icon_message_size',['size' => config('images.validate.category_icon.max_size')]) }}"
    data-max-size="{{ config('images.validate.category_icon.max_size') }}">
</div>
<div id="statusForm" data-status=""></div>
<div class="form-group required">
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
                'placeholder' => trans('admin/category.placeholder.name'),
                'required'
            ])
        }}
    </div>
</div>
<div class="form-group required">
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
                'placeholder' => trans('admin/category.placeholder.short_name'),
                'required'
            ])
        }}
    </div>
</div>
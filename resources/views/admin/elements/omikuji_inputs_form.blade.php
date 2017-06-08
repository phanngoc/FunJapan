<div id="imageMimes" data-mimes="{{ config('images.validate.omikuji_image.mimes') }}"
    data-message="{{ trans('admin/omikuji.image_message',['type' => config('images.validate.omikuji_image.mimes')]) }}"
    data-message-size="{{ trans('admin/omikuji.image_message_size',['size' => config('images.validate.omikuji_image.max_size')]) }}"
    data-max-size="{{ config('images.validate.omikuji_image.max_size') }}">
</div>
<div id="imageItemMimes" data-mimes="{{ config('images.validate.omikuji_item_image.mimes') }}"
    data-message="{{ trans('admin/omikuji.image_message',['type' => config('images.validate.omikuji_item_image.mimes')]) }}"
    data-message-size="{{ trans('admin/omikuji.image_message_size',['size' => config('images.validate.omikuji_item_image.max_size')]) }}"
    data-max-size="{{ config('images.validate.omikuji_item_image.max_size') }}">
</div>
<div id="statusForm" data-status=""></div>
<div id="delMessage" data-msg="{{ trans('admin/omikuji.delete_new_confirm') }}"></div>

<div class="form-group required">
    {{ Form::label(
        'name',
        trans('admin/omikuji.label.name'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10 width30">
        {{ Form::text(
            'name',
            $omikuji->name ?? '',
            [
                'class' => 'form-control',
                'placeholder' => trans('admin/omikuji.placeholder.name'),
                'required',
            ])
        }}
    </div>
</div>

<div class="form-group">
    {{ Form::label(
        'description',
        trans('admin/omikuji.label.description'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10 width30">
        {{ Form::text(
            'description',
            $omikuji->description ?? '',
            [
                'class' => 'form-control',
                'placeholder' => trans('admin/omikuji.placeholder.description'),
            ])
        }}
    </div>
</div>

<div class="form-group required">
    {{ Form::label(
        'start_time',
        trans('admin/omikuji.label.start_time'),
        [ 'class' => 'col-sm-2 control-label' ])
    }}
    <div class="col-sm-10 width30">
        {{ Form::text(
            'start_time',
            $omikuji->start_time ?? '',
            [
                'class' => 'form-control datetime-picker',
                'required'
            ])
        }}
    </div>
</div>

<div class="form-group">
    {{ Form::label(
        'end_time',
        trans('admin/omikuji.label.end_time'),
        ['class' => 'col-sm-2 control-label'])
    }}
    <div class="col-sm-10 width30">
        {{ Form::text(
            'end_time',
            $omikuji->end_time ?? '',
            ['class' => 'form-control datetime-picker'])
        }}
    </div>
</div>

<div class="form-group required">
    {{ Form::label(
        'recover_time',
        trans('admin/omikuji.label.recover_time'),
        [
            'class' => 'col-sm-2 control-label',
        ])
    }}
    <div class="col-sm-10 width30">
        {{ Form::text(
            'recover_time',
            $omikuji->recover_time ?? '',
            [
                'class' => 'form-control',
                'placeholder' => trans('admin/omikuji.placeholder.recover_time'),
                'required',
                'pattern'=> '[0-9]*',
            ])
        }}
    </div>
</div>
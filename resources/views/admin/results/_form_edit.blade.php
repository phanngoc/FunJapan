<div class="form-result">
    <div class="form-group required">
        {{ Form::label(
            'title',
            trans('admin/result.title'),
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-9">
            {{ Form::text(
                'result[0][title]',
                $result->title ?? '',
                [
                    'class' => 'form-control title',
                    'required',
                ])
            }}
            <p class="text-danger font-bold error-title"></p>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
            'require_point',
            trans('admin/result.score_from'),
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-4">
            {{ Form::text(
                'result[0][required_point_from]',
                ($result->required_point_from != 0) ? $result->required_point_from : '',
                [
                    'class' => 'form-control score_from',
                    'required',
                ])
            }}
            <p class="text-danger font-bold error-score-from"></p>
        </div>
        {{ Form::label(
            'require_point',
            trans('admin/result.score_to'),
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-4">
            {{ Form::text(
                'result[0][required_point_to]',
                ($result->required_point_to != 0) ? $result->required_point_to : '',
                [
                    'class' => 'form-control score_to',
                    'required',
                ])
            }}
            <p class="text-danger font-bold error-score-to"></p>
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
            'photo',
            trans('admin/result.image'),
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-9 pt5">
            {{ Form::file(
                'result[0][photo]',
                [
                    'class' => 'form-control photo',
                    'accept' => 'image/jpeg,image/png,image/jpg',
                ])
            }}
        </div>
    </div>
    <div class="form-group preview-section">
        <div class="col-sm-4 col-sm-offset-1">
            <img src="{{ $result->photoUrl['small'] }}" class="preview-img" data-url="{{ $result->photoUrl['small'] }}">
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
            'description',
            trans('admin/result.detail'),
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-9">
            {{ Form::textarea(
                'result[0][description]',
                $result->description ?? '',
                [
                    'class' => 'article-content description',
                ])
            }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label(
            'bottom_text',
            trans('admin/result.bottom_text'),
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-9">
            {{ Form::text(
                'result[0][bottom_text]',
                $result->bottom_text ?? null,
                [
                    'class' => 'form-control bottom_text',
                ])
            }}
            <p class="text-danger font-bold error-bottom-text"></p>
        </div>
    </div>
    <input type="hidden" value="{{$result->id}}" name="result[0][id]" class="result-id">
</div>

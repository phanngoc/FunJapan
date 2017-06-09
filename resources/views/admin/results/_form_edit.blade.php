@foreach($results as $key => $result)
<div class="form-result">
    <div class="form-group">
        {{ Form::label(
            'require_point',
            trans('admin/result.score_from'),
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-4">
            {{ Form::text(
                'result['.$key.'][required_point_from]',
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
                'result['.$key.'][required_point_to]',
                ($result->required_point_to != 0) ? $result->required_point_to : '',
                [
                    'class' => 'form-control score_to',
                    'required',
                ])
            }}
            <p class="text-danger font-bold error-score-to"></p>
        </div>
        <div class="col-sm-1">
            <a data-toggle="tooltip" data-placement="top" href="javascript:;" title="Delete Result" class="delete"><i class="fa fa-trash fa-lg"></i></a>
        </div>
    </div>
    <div class="form-group required">
        {{ Form::label(
            'title',
            trans('admin/result.title'),
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-9">
            {{ Form::text(
                'result['.$key.'][title]',
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
            'photo',
            trans('admin/result.image'),
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-9 pt5">
            {{ Form::file(
                'result['.$key.'][photo]',
                [
                    'class' => 'form-control photo',
                ])
            }}
        </div>
    </div>
    <div class="form-group" class="preview-section">
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
                'result['.$key.'][description]',
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
                'result['.$key.'][bottom_text]',
                $result->bottom_text ?? null,
                [
                    'class' => 'form-control bottom_text',
                ])
            }}
        </div>
    </div>
    <input type="hidden" value="{{$result->id}}" name="result[{{$key}}][id]" class="result-id">
    <hr>
</div>

@endforeach
<div id="statusForm" data-status=""></div>
@foreach($results as $result)
<div class="form-result">
    <div class="form-group">
        {{ Form::label(
            'require_point',
            'Score From',
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-4">
            {{ Form::text(
                'result['.$result->id.'][required_point_from]',
                $result->required_point_from ?? '',
                [
                    'class' => 'form-control score_from',
                    'required',
                ])
            }}
        </div>
        {{ Form::label(
            'require_point',
            'Score To',
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-4">
            {{ Form::text(
                'result['.$result->id.'][required_point_to]',
                $result->required_point_to ?? '',
                [
                    'class' => 'form-control score_to',
                    'required',
                ])
            }}
        </div>
        <div class="col-sm-1">
            <a data-toggle="tooltip" data-placement="top" href="javascript:;" title="Delete Result" class="delete"><i class="fa fa-trash fa-lg"></i></a>
        </div>
    </div>
    <p class="text-danger font-bold error-score-from"></p>
    <p class="text-danger font-bold error-score-to"></p>
    <div class="form-group required">
        {{ Form::label(
            'title',
            'Title',
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-9">
            {{ Form::text(
                'result['.$result->id.'][title]',
                $result->title ?? '',
                [
                    'class' => 'form-control title',
                    'required',
                ])
            }}
        </div>
    </div>
    <p class="text-danger font-bold error-title"></p>
    <div class="form-group">
        {{ Form::label(
            'photo',
            'Image',
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-9 pt5">
            {{ Form::file(
                'result['.$result->id.'][photo]',
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
            'Detail',
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-9">
            {{ Form::textarea(
                'result['.$result->id.'][description]',
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
            'Bottom Text',
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-9">
            {{ Form::text(
                'result['.$result->id.'][bottom_text]',
                $result->bottom_text ?? null,
                [
                    'class' => 'form-control bottom_text',
                ])
            }}
        </div>
    </div>
    <input type="hidden" value="{{$result->id}}" name="result[{{$result->id}}][id]" class="result-id">
    <hr>
</div>

@endforeach
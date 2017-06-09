<div class="form-result">
    <div class="form-group">
        {{ Form::label(
            'require_point',
            trans('admin/result.score_from'),
            ['class' => 'col-sm-1 control-label'])
        }}
        <div class="col-sm-4">
            {{ Form::text(
                'result['.$id.'][required_point_from]',
                $result->required_point_from ?? '',
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
                'result['.$id.'][required_point_to]',
                $result->required_point_to ?? '',
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
                'result['.$id.'][title]',
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
                'result['.$id.'][photo]',
                ['class' => 'form-control photo'])
            }}
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
                'result['.$id.'][description]',
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
                'result['.$id.'][bottom_text]',
                $result->bottom_text ?? null,
                [
                    'class' => 'form-control bottom_text',
                ])
            }}
        </div>
    </div>
</div>
<div id="statusForm" data-status=""></div>
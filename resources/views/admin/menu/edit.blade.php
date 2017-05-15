@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/menu.menu_edit') }}</h2></div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\MenusController@update', $menu->id], 'id' => 'create-menu-form', 'class' => 'form-horizontal', 'files' => true]) }}
                    {{ method_field('PUT') }}

                    {{ Form::hidden('locale_id', $menu->locale_id) }}

                    <div class="form-group required">
                        {{ Form::label(
                            'name',
                            trans('admin/menu.label.name'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::text(
                                'name',
                                $menu->name,
                                ['class' => 'form-control', 'required'])
                            }}
                        </div>
                    </div>

                    @if ($menu->type == 'link')
                        <div class="form-group required" id="section_link">
                            {{ Form::label(
                                'link',
                                trans('admin/menu.label.link'),
                                ['class' => 'col-sm-2 control-label'])
                            }}
                            <div class="col-sm-10" id="link_input">
                                {{ Form::text(
                                    'link',
                                    $menu->link,
                                    ['class' => 'form-control', 'required'])
                                }}
                            </div>
                        </div>
                    @endif

                    <div class="form-group required">
                        {{ Form::label(
                            'description',
                            trans('admin/menu.label.description'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::textarea(
                                'description',
                                $menu->description,
                                ['class' => 'form-control', 'required'])
                            }}
                        </div>
                    </div>

                    @if ($menu->type == config('menu.parent_type.category'))
                        <div class="form-group required category-list">
                            {{ Form::label('category', trans('admin/menu.label.category'), [
                                'class' => 'col-sm-2 control-label'
                            ]) }}
                            <div class="col-sm-10">
                                {{ Form::select('category', $categories, $selectedCategoriesId, ['class' => 'form-control', 'multiple']) }}
                            </div>
                        </div>

                        <div class="form-group category-selected">
                            {{ Form::label('category', trans('admin/menu.label.selected_category'), [
                                'class' => 'col-sm-2 control-label'
                            ]) }}
                            {{ Form::hidden('selectedCategories', implode(',', $selectedCategoriesId), ['class' => 'category-selected-hidden']) }}
                            <div class="col-sm-10">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('admin/menu.label.category_name') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="sortable-category">
                                        @foreach ($selectedCategoriesId as $key => $categoryId)
                                            <tr data-id="{{ $categoryId }}"><td>{{ $categories[$categoryId] }}</td></tr>
                                        @endforeach
                                        @foreach ($categories as $id => $name)
                                            @if (!in_array($id, $selectedCategoriesId))
                                                <tr class="hidden" data-id="{{ $id }}"><td>{{ $name }}</td></tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        {{ Form::label(
                            'icon',
                            trans('admin/menu.label.icon'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt5">
                            {{ Form::file(
                                'icon',
                                '',
                                ['class' => 'form-control', 'required'])
                            }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <img src="{{ $menu->icon_url['normal'] }}">
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'icon_class',
                            trans('admin/menu.label.icon_class'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::text(
                                'icon_class',
                                $menu->icon_class,
                                ['class' => 'form-control'])
                            }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/article.button.update'),
                                [
                                    'class' => 'btn btn-primary',
                                    'id' => 'menu-create',
                                ])
                            }}
                        </div>

                        <div class="col-sm-3">
                            <a class="btn btn-primary" href="{{ action('Admin\MenusController@index') }}">
                            {{ trans('admin/menu.button.cancel') }}
                            </a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    <script type="text/javascript">
        var oldInputs = {!! json_encode(old()) !!};
        var urlGetCategories = "{!! action('Admin\MenusController@getCategories') !!}";
    </script>
    {!! Html::script('assets/admin/js/menu.js') !!}
@stop
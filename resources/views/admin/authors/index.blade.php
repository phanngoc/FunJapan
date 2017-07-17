<div class="wrapper wrapper-content animated fadeInRight">
    @include('admin.authors.create')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/author.list') }}</h2></div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="input-group col-md-6 form-search">
                                <div class="input-group-btn">
                                    <button class="btn btn-white btn-left-radius" type="button" style="cursor: not-allowed;">
                                        <b class="selected-search-by">
                                            {{ trans('admin/author.label.name') }}
                                        </b>
                                    </button>
                                </div>
                                {!! Form::text('keyword', $filter['keyword'] ?? null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Search',
                                ]) !!}
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary btn-right-radius" id="search-author"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="table-author">
                        @include('admin/authors._table')
                    </table>
                    <div class="box-footer clearfix pagination-limit">
                        <div class="select-limit">
                            <div class="form-inline">
                                <div class="form-group" id="showing-author">
                                    {{ trans('admin/author.label.total') }}
                                    {{ $total_authors ?? 0 }}
                                    {{ trans('admin/author.label.items') }}
                                </div>
                                <div class="form-group pull-right" id="paginate-author">
                                    @include('admin/elements._paginate', ['results' => $authors])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="image-mimes" data-mimes="{{ config('images.validate.author.mimes') }}"
    data-message="{{ trans('admin/author.image_message',['type' => config('images.validate.author.mimes')]) }}"
    data-message-size="{{ trans('admin/author.image_message_size',['size' => config('images.validate.author.max_size')]) }}"
    data-max-size="{{ config('images.validate.author.max_size') }}">
</div>
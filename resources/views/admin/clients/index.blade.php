<div class="wrapper wrapper-content animated fadeInRight">
    @include('admin.clients.create')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/client.list') }}</h2></div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="input-group col-md-6 form-search">
                                <div class="input-group-btn">
                                    <button class="btn btn-white btn-left-radius" type="button" style="cursor: not-allowed;">
                                        <b class="selected-search-by">
                                            {{ trans('admin/client.label.name') }}
                                        </b>
                                    </button>
                                </div>
                                {!! Form::text('keyword', $filter['keyword'] ?? null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Search',
                                    'maxlength' => '255',
                                ]) !!}
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary btn-right-radius" id="search-client"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="table-client">
                        @include('admin/clients._table')
                    </table>

                    <div class="box-footer clearfix pagination-limit">
                        <div class="select-limit">
                            <div class="form-inline">
                                <div class="form-group" id="showing-client">
                                    {{ trans('admin/author.label.showing') }}
                                    {{ $total_clients ?? 0 }}
                                    {{ trans('admin/author.label.items') }}
                                </div>
                                <div class="form-group pull-right" id="paginate-client">
                                    @include('admin/elements._paginate', ['results' => $clients])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-30 sidebar">
    <!-- SIDEBAR -->
    <div class="sidebar-detail">
        <!-- ABOUT AUTHOR -->
        <div class="list-group detail-about-author">
            <div class="list-group-header">
                <p class="list-group-title">{{ trans('admin/global.author') }}</p>
            </div>
            <p class="about-author">
                {{ isset($article->locale->article->author) ? $article->locale->article->author->description : '' }}
            </p>
        </div>
        <!-- EOF ABOUT AUTHOR -->
        @include('web.comments._comments_area', ['articleLocale' => $article->locale])
    </div>
    <!-- EOF SIDEBAR -->
</div>

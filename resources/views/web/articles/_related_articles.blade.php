@if (count($articles))
    <div class="related-post">
        <div class="row gutter-16">
            <div class="col-md-6 col-xs-8">
                @include('web.articles._single_article_block_1', ['article' => $articles[0]])
            </div>
            <div class="col-md-6 col-xs-4">
                <div class="row gutter-16">
                    <div class="col-md-6">
                        @if (isset($articles[1]))
                            @include('web.articles._single_article_block_2', ['article' => $articles[1]])
                        @endif

                        @if (isset($articles[2]))
                            @include('web.articles._single_article_block_2', ['article' => $articles[2]])
                        @endif
                    </div>
                    <div class="col-md-6 sm-rm">
                        @if (isset($articles[3]))
                            @include('web.articles._single_article_block_2', ['article' => $articles[3]])
                        @endif

                        @if (isset($articles[4]))
                            @include('web.articles._single_article_block_2', ['article' => $articles[4]])
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row gutter-16">
            <div class="col-md-6 col-xs-4">
                <div class="row gutter-16">
                    <div class="col-md-6">
                        @if (isset($articles[5]))
                            @include('web.articles._single_article_block_2', ['article' => $articles[5]])
                        @endif
                    </div>
                    <div class="col-md-6 sm-rm">
                        @if (isset($articles[6]))
                            @include('web.articles._single_article_block_2', ['article' => $articles[6]])
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-8">
                @if (isset($articles[7]))
                    @include('web.articles._single_article_block_2', ['article' => $articles[7]])
                @endif
            </div>
        </div>
    </div>
@endif


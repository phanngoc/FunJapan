<div class="sns-container">
    <div class="sns-btn-group">
        <div class="row gutter-4">
            <div class="col-xs-1">
                <a target="_blank"
                    class="btn fb"
                    role="button"
                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span><i class="fa fa-facebook t4" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-xs-1">
                <a target="_blank"
                    class="btn gp"
                    role="button"
                    href="https://plus.google.com/share?url={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span><i class="fa fa-google-plus t4" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-xs-1">
                <a target="_blank"
                    class="btn tw"
                    role="button"
                    href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span><i class="fa fa-twitter t4" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-xs-1">
                <a href="https://timeline.line.me/social-plugin/share?url={{ $url }}"
                    onclick="countShare({{$articleLocale->article_id}});"
                    target="_blank" class="btn line">
                    <span><i class="fa fa-whatsapp t4" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-xs-1">
                <a href="https://getpocket.com/edit.php?url={{ $url }}"
                    onclick="countShare({{$articleLocale->article_id}});"
                    target="_blank" class="btn gp">
                    <span><i class="fa fa-get-pocket t4" aria-hidden="true"></i></span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="sns-container sm">
    <div class="sns-btn-group">
        <div class="row gutter-4">
            <div class="col-xs-2">
                <a target="_blank"
                    class="btn fb"
                    role="button"
                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span><i class="fa fa-facebook t4" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-xs-2">
                <a target="_blank"
                    class="btn gp"
                    role="button"
                    href="https://plus.google.com/share?url={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span><i class="fa fa-google-plus t4" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-xs-2">
                <a target="_blank"
                    class="btn tw"
                    role="button"
                    href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span><i class="fa fa-twitter t4" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-xs-2">
                <a href="https://timeline.line.me/social-plugin/share?url={{ $url }}"
                    onclick="countShare({{$articleLocale->article_id}});"
                    target="_blank" class="btn line">
                    <span><i class="fa fa-whatsapp t4" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-xs-2">
                <a href="https://getpocket.com/edit.php?url={{ $url }}"
                    onclick="countShare({{$articleLocale->article_id}});"
                    target="_blank" class="btn gp">
                    <span><i class="fa fa-get-pocket t4" aria-hidden="true"></i></span>
                </a>
            </div>
        </div>
    </div>
</div>

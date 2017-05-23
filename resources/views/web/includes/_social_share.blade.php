<div class="sns-container">
    <div class="sns-btn-group">
        <div class="row gutter-4">
            <div class="col-xs-6">
                <a target="_blank"
                    class="btn fb"
                    role="button"
                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span><i class="fa fa-facebook" aria-hidden="true"></i> share on facebook</span>
                </a>
            </div>
            <div class="col-xs-6">
                <a target="_blank"
                    class="btn gp"
                    role="button"
                    href="https://plus.google.com/share?url={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span><i class="fa fa-google-plus" aria-hidden="true"></i> share on google</span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="sns-container sm">
    <div class="sns-btn-group">
        <div class="row gutter-4">
            <div class="col-xs-6">
                <a target="_blank"
                    class="btn fb"
                    role="button"
                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span>Share on&nbsp;&nbsp;<i class="fa fa-facebook-square" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-xs-6">
                <a target="_blank"
                    class="btn gp"
                    role="button"
                    href="https://plus.google.com/share?url={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span>Share on&nbsp;&nbsp;<i class="fa fa-google-plus" aria-hidden="true"></i></span>
                </a>
            </div>
        </div>
    </div>
</div>

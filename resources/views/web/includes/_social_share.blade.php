<div class="sns-container">
    <div class="sns-btn-group">
        <div class="row gutter-4">
            <div class="col-xs-3">
                <a target="_blank"
                    class="btn fb"
                    role="button"
                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span><i class="fa fa-facebook" aria-hidden="true"></i> share on facebook</span>
                </a>
            </div>
            <div class="col-xs-3">
                <a target="_blank"
                    class="btn gp"
                    role="button"
                    href="https://plus.google.com/share?url={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span><i class="fa fa-google-plus" aria-hidden="true"></i> share on google</span>
                </a>
            </div>
            <div class="col-xs-3">
                <a target="_blank"
                    class="btn tw"
                    role="button"
                    href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span><i class="fa fa-twitter" aria-hidden="true"></i> share on twitter</span>
                </a>
            </div>
            <div class="col-xs-1">
                <a class="btn more dropdown" data-toggle="dropdown"><span><i class="fa fa-plus"></i></span></a>
                <ul class="dropdown-menu settings">
                    <li>
                        <div class="dropdown-menu-global">
                            <ul class="pl1">
                                <div>
                                    <div class="line-it-button" data-article="{{ $articleLocale->article_id }}" style="display: none;" data-type="share-d" data-lang="en" data-url="{{ $url }}"></div>
                                    <a href="https://getpocket.com/edit.php?url={{ $url }}" target="_blank" class="btn gp w40">
                                        <span><i class="fa fa-get-pocket" aria-hidden="true"></i></span>
                                    </a>
                                </div>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="sns-container sm">
    <div class="sns-btn-group">
        <div class="row gutter-4">
            <div class="col-xs-3">
                <a target="_blank"
                    class="btn fb"
                    role="button"
                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span>Share on&nbsp;&nbsp;<i class="fa fa-facebook-square" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-xs-3">
                <a target="_blank"
                    class="btn gp"
                    role="button"
                    href="https://plus.google.com/share?url={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span>Share on&nbsp;&nbsp;<i class="fa fa-google-plus" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-xs-3">
                <a target="_blank"
                    class="btn tw"
                    role="button"
                    href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}"
                    onclick="countShare({{$articleLocale->article_id}});">
                    <span>Share on&nbsp;&nbsp;<i class="fa fa-twitter-square" aria-hidden="true"></i></span>
                </a>
            </div>
            <div class="col-xs-2 w15">
                <a class="btn more dropdown" data-toggle="dropdown"><span><i class="fa fa-plus"></i></span></a>
                <ul class="dropdown-menu settings">
                    <li>
                        <div class="dropdown-menu-global">
                            <ul class="pl1">
                                <div>
                                    <div class="line-it-button" data-article="{{ $articleLocale->article_id }}" style="display: none;" data-type="share-d" data-lang="en" data-url="{{ $url }}"></div>
                                    <a href="https://getpocket.com/edit.php?url={{ $url }}" target="_blank" class="btn gp w40">
                                        <span><i class="fa fa-get-pocket" aria-hidden="true"></i></span>
                                    </a>
                                </div>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

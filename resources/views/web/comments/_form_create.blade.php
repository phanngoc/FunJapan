<form role="form" class="comment-to-top">
    <textarea class="form-control no-radius-bot" rows="4" placeholder="What's on your mind?"></textarea>
    <div class="row radius-bot">
        <div class="col-xs-8 text-left">
            <span type="button" class="btn btn-gif show-gifs-selection">GIF</span>
            <div class="gifs-comment-block" id="gifs-search-block" style="display: none; bottom: -398px;">
                <div class="popup-gif">
                    <div class="popup-content">
                        <div class="search-for-text">
                            <input type="text" id="search-gif-input" class="form-control text-search-gif pull-left input-sm"
                                autocomplete="off" placeholder="Search images">
                            <input type="text" class="hidden">
                            <i class="fa fa-level-down fa-rotate-90 search-image-gif" id="search-gif-btn" aria-hidden="true"></i>
                            <button id="close-gif-popup-btn" class="gif-header-button pull-right" type="button">
                                <i class="glyphicon glyphicon-off"></i>
                            </button>
                            <input type="hidden" id="gif-for-parent-comment-id" value="">
                        </div>
                        <div class="body-result-gifs"></div>
                    </div>
                </div>
            </div>
            <i class="fa fa-smile-o btn btn-twemoji" aria-hidden="true"></i>
            <div class="gifs-comment-block" id="emoji-picker-block" style="display: none; bottom: 34px;">
                <div class="popup-gif">
                    <div class="popup-content">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-4 text-right">
            <button type="button" class="btn btn-default" id="post-btn"><i class="fa fa-comments-o" aria-hidden="true"></i></button>
        </div>
    </div>
</form>

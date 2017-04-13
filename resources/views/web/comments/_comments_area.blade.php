<!-- COMMENT AREA -->
<div id="comment-area" class="comment-area">
    <div id="comment-area-desktop">
        <div class="list-group">
            <div class="list-group-header">
                <p class="list-group-title">
                    <span class="comment-count">119</span> COMMENTS
                </p>
            </div>
            <!-- HIDE COMMENT MODAL BTN -->
            <div class="hide-comment-modal">
                <p><span class="comment-count">119</span> COMMENTS
                    <a id="hide-comment-btn"><span class="suggest-text pull-right">close <i class="fa fa-times pull-right" aria-hidden="true"></i></span></a></p>
            </div>
            <!-- EOF HIDE COMMENT MODAL BTN -->
        </div>
        <div class="comment-posting-form">
            <div class="alert alert-danger hidden">
                <ul>
                    <li class="hidden">Posting comments is limited temporarily. Try again later. </li>
                    <li class="hidden">Message is too long.</li>
                    <li class="hidden">You have reached your comment limit for this article.</li>
                </ul>
            </div>
            @include('web.comments._form_create')
            <div class="login-requirement">
                <span><a href="#">Login</a> or <a href="#">create your account</a> to join the discussion.</span>
            </div>
            @include('web.comments._form_reply')
            @include('web.comments._list_comments')
        </div>
    </div>
    <!-- COMMENT MODAL -->
    <div class="modal fade" id="comment-modal">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <!-- EOF COMMENT MODAL -->
    <!-- SHOW COMMENT MODAL BTN -->
    <div class="show-comment-modal">
        <p><span class="comment-count">119</span> COMMENTS
            <a id="show-comment-btn"><span class="suggest-text pull-right">swipe up <i class="fa fa-hand-o-up" aria-hidden="true"></i></span></a></p>
    </div>
    <!-- EOF SHOW COMMENT MODAL BTN -->
    <!-- DELETE COMMENT MODAL -->
    <div class="modal fade" id="delete-comment-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- EOF DELETE COMMENT MODAL -->
    <!-- CONFIRM GIF MODAL -->
    <div class="modal fade" id="confirm-gif-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to post this GIF image?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- EOF CONFIRM GIF MODAL -->
</div>
<!-- EOF COMMENT AREA -->

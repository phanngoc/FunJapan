<div class="row invite-links">
    <a class="popover-item-share"
        target="_blank"
        href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}?referralId={{ auth()->user()->invite_code }}">
        <div class="col-xs-3 text-center invite-facebook">
            <i class="fa fa-facebook-square"></i>
            <p>{{ trans('web/invite_friend.share_facebook') }}</p>
        </div>
    </a>
    <a class="popover-item-share"
        target="_blank"
        href="http://www.twitter.com/share?url={{ $url }}?referralId={{ auth()->user()->invite_code }}">
        <div class="col-xs-3 text-center invite-twitter">
            <i class="fa fa-twitter-square"></i>
            <p>{{ trans('web/invite_friend.share_twitter') }}</p>
        </div>
    </a>
    <a class="popover-item-share" href="mailto:?subject={{ $subject }}&body={{ $content }}">
        <div class="col-xs-3 text-center invite-email">
            <i class="fa fa-envelope-square"></i>
            <p>{{ trans('web/invite_friend.invite_email') }}</p>
        </div>
    </a>
    <a class="popover-item-share" target="_blank" href="#invite-link-dialog" data-toggle="modal">
        <div class="col-xs-3 text-center invite-link">
            <i class="fa fa-link"></i>
            <p>{{ trans('web/invite_friend.share_link') }}</p>
        </div>
    </a>
</div>
<div id="invite-link-dialog" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body form-group">
                <p>{{ trans('web/invite_friend.please_share') }}</p>
                <input class="form-control" type="text" value="{{ $url }}?referralId={{ auth()->user()->invite_code }}">
            </div>
        </div>
    </div>
</div>
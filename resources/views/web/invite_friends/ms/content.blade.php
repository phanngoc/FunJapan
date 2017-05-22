@extends('web.invite_friends.layout_invite')

@section('content-child')
    <div>
        <h3>Invite Your Friends</h3>
    </div>
    <div class="text-center">
        <h4>You can get 1,000pt when you invite your friends and they registerd.</h4>

        <div style="margin-top: 40px;">
            <h4>How it Works</h4>
            <p>1. You click the link below, and you share the registration url to your friends.</p>
            <p>2. Your friends click the registration link, and they register.</p>
            <p>3. You get 1,000pt each with the your friend, up to 20 people in one month.</p>
        </div>

        @include('web.invite_friends._share_social')

        <div class="row">
            <h4>You have invited</h4>
            <div class="col-xs-2"></div>
            <div class="col-xs-4 invited-count">
                <h4>This Month</h4>
                <h3>0</h3>
                <p>friends</p>
            </div>
            <div class="col-xs-4 invited-count">
                <h4>Total</h4>
                <h3>0</h3>
                <p>friends</p>
            </div>
            <div class="col-xs-2"></div>
        </div>

        <p style="color:red;">*You can get points up to 20 people per month. Not get any more.</p>
    </div>
@endsection
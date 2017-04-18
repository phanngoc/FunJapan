<p>
    Someone requested an account recovery on Fun! Japan for {{ $email }}. If you did not request this, just ignore this email. Your account will be kept safe.
</p>

<p>
    If you would like to reset your password, please click the following link and specify a new password.
<p>

<p>
    <a href="{{ action('Web\ResetPasswordController@resetPassword', ['token' => $token]) }}">
        {{ action('Web\ResetPasswordController@resetPassword', ['token' => $token]) }}
    </a>
<p>

<p>
    Please do not reply to this e-mail address. We can't receive.
<p>
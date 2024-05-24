
<h1>Forget Password Email</h1>
You can reset password from bellow link:
<br>
<a href="{{ route('auth.showResetPasswordForm', $token) }}">{{ route('auth.showResetPasswordForm', $token) }}</a>
<br>
<p>Or simply click the button below:</p>
<br>
<a href="{{ route('auth.showResetPasswordForm', $token) }}"><button style="width: auto;padding: 12px 15px;font-size: 15px;border:none;color:white;background: #4749ad">Reset Password</button></a>

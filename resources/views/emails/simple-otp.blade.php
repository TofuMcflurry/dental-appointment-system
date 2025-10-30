<h3>Password Change Verification</h3>
<p>Hello {{ $user->name }},</p>
<p>You are changing your password. Use this verification code:</p>
<h2 style="color: #007bff;">{{ $otp }}</h2>
<p>This code expires in {{ $expires_in }} minutes.</p>
<p>If you didn't request this, please ignore this email.</p>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Login Credentials</title>
<style>
    body { margin: 0; padding: 0; background: #f4fafa; font-family: Arial, sans-serif; color: #242424; }
    .wrap { max-width: 620px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
    .header { background: #1ab69d; padding: 32px 40px; text-align: center; }
    .header h1 { margin: 0; color: #ffffff; font-size: 26px; font-weight: 900; letter-spacing: 0.5px; }
    .header p { margin: 6px 0 0; color: rgba(255,255,255,0.85); font-size: 14px; }
    .body { padding: 36px 40px; }
    .creds-box { background: #f4fafa; border: 1px solid #e7e7e7; border-radius: 6px; padding: 24px; margin: 24px 0; }
    .creds-box h2 { margin: 0 0 16px; font-size: 15px; color: #171717; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
    .cred-row { display: flex; align-items: center; margin-bottom: 12px; font-size: 15px; }
    .cred-label { color: #777; width: 110px; flex-shrink: 0; }
    .cred-value { font-weight: 800; color: #171717; background: #fff; border: 1px solid #dedede; border-radius: 4px; padding: 6px 14px; font-family: monospace; font-size: 15px; }
    .note { font-size: 13px; color: #999; margin-top: 10px; }
    .cta { text-align: center; margin: 28px 0; }
    .cta a { background: #1ab69d; color: #ffffff !important; text-decoration: none; padding: 14px 36px; border-radius: 6px; font-size: 16px; font-weight: 800; display: inline-block; }
    .footer { background: #f4fafa; padding: 24px 40px; text-align: center; font-size: 13px; color: #999; border-top: 1px solid #e7e7e7; }
    .footer a { color: #1ab69d; text-decoration: none; }
</style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <h1>CEUTrainers</h1>
        <p>Your Login Credentials</p>
    </div>

    <div class="body">
        <p style="font-size:17px; margin-bottom:8px;">Hi <strong>{{ $user->name }}</strong>,</p>
        <p style="font-size:15px; margin-top:0; color:#555;">We received a request to send your login credentials. Here they are:</p>

        <div class="creds-box">
            <h2>Login Details</h2>
            <div class="cred-row">
                <span class="cred-label">Email</span>
                <span class="cred-value">{{ $user->email }}</span>
            </div>
            <div class="cred-row">
                <span class="cred-label">Password</span>
                <span class="cred-value">{{ $plainPassword }}</span>
            </div>
            <p class="note">This is a newly generated password. Please keep it safe.</p>
        </div>

        <div class="cta">
            <a href="{{ url('/login') }}">Login Now</a>
        </div>

        <p style="font-size:13px; color:#aaa; margin-top:24px;">If you did not request this, you can ignore this email — your previous password has been changed. Please contact us immediately if you did not make this request.</p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} CEUTrainers. All rights reserved.<br>
        <a href="{{ url('/') }}">Visit our website</a>
    </div>
</div>
</body>
</html>

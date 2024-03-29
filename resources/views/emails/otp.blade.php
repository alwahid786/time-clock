<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <h1 style="color: #333333;">Password Reset OTP</h1>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 20px 0;">
                <p style="font-size: 16px; color: #333333;">Dear User,</p>
                <p style="font-size: 16px; color: #333333;">You have requested to reset your password. Please use the following OTP:</p>
                <div style="background-color: #17a2b8; color: #ffffff; font-size: 32px; padding: 10px 20px; border-radius: 5px; display: inline-block;">
                    <strong>{{ $otp }}</strong>
                </div>
                <p style="font-size: 16px; color: #333333;">This OTP is valid for a limited time.</p>
                <p style="font-size: 16px; color: #333333;">If you did not request this, please ignore this email.</p>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 20px 0;">
                <p style="font-size: 16px; color: #333333;">Best regards,<br>Time Clock</p>
            </td>
        </tr>
    </table>
</body>

</html>

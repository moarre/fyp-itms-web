<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Details</title>
</head>
<body style="font-family: Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #333; background-color: #f7f7f7; margin: 0; padding: 0;">
    <table style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #fff; border-collapse: collapse;">
        <tr>
            <td style="padding: 20px;">
                <h1 style="margin: 0;">Account Details</h1>
                <p style="margin-top: 20px;">Hello {{ $user->name }},</p>
                <p>Thank you for registering with us. Your account details are as follows:</p>
                <ul>
                    <li>Username: {{ $user->username }}</li>
                    <li>Email: {{ $user->email }}</li>
                    <li>Password: {{ $user->password }}</li>
                </ul>
                <p>If you have any questions or concerns, please don't hesitate to contact us.</p>
                <p>Regards,</p>
                <p>The Team</p>
            </td>
        </tr>
    </table>
</body>
</html>

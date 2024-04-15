<!DOCTYPE html>
<html>

<head>
    <title>User Credentials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #17a2b8;
            text-align: center;
        }

        p {
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Your Credentials:</h1>
        <p><b>CONGRATULATIONS!</b> Your account has been created. Now you can access your account using credentials below at this link: <a href="{{env('APP_URL')}}/public/login">Time Clock</a></p>
        <p>Email: {{ $email }}</p>
        <p>Password: {{ $password }}</p>
    </div>
    <div class="footer">
        Sent from Time Clock.
    </div>
</body>

</html>

<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email Address</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}</h1>
    <p>
        Please click the link below to verify your email address:
        <a href="{{ route('verification.verify', $user->id) }}">Verify Email</a>
    </p>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery Admin Invitation</title>
</head>
<body>
    <h2>Bakery Admin Invitation</h2>
    <p>You have been invited to become an admin for the bakery.</p>
    <p>Click the link below to confirm and create your account password:</p>
    <p>
        <a href="{{ url('/invite/accept/' . $token) }}">Accept Admin Invitation</a>
    </p>
    <p>If you did not expect this email, you can ignore it.</p>
</body>
</html>

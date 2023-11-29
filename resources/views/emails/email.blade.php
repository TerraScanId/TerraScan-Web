<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TerraScan</title>
</head>
<body>
    <h1>{{ $mailData['title'] }}</h1>

    Dear {{ $mailData['email'] }},
    <br>

    Kami menerima permintaan untuk mereset password akun Anda pada TerraScan. Untuk melanjutkan proses reset password, silakan klik tautan di bawah ini:

    <br>
    <br>
    <a href="{{ $mailData['url'] }}">reset password</a>
    <br>
    <br>

    Jika Anda tidak merasa melakukan permintaan ini, Anda dapat mengabaikan email ini.
    <br>
    Terima kasih,
    <br>
    Tim TerraScan

</body>
</html>
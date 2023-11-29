<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url={{ route('login') }}">
    <title>Success Redirect</title>
</head>
<body>
    <p>Kata sandi berhasil diubah. Anda akan diarahkan kembali ke laman login dalam 5 detik.</p>
    <a href="{{ route('login') }}">klik disini jika tidak kembali</a>

    <script>
        setTimeout(function () {
            window.location.href = '{{ route('login') }}';
        }, 5000);
    </script>
</body>
</html>
<!DOCTYPE html> <html lang="en"> <head> <meta charset="utf-8"> <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Log In</title>
    <!-- bootstrap css -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> <!--
    style css -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> <!-- Responsive--> <link rel="stylesheet"
    href="{{ asset('assets/css/responsive.css') }}">

<!-- font awesome style -->
<!-- <link href="css/font-awesome.min.css" rel="stylesheet" /> -->
<!-- fevicon -->
<link rel="icon" href="{{ asset('assets/images/icon.png') }}" />
<!-- Font -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
    media="screen">
</head>

<!-- Body -->

<body>
    <div class="container">
        <div class="login-page align-items-center">
            <div class="form-login">
                <p class="fw-bold fs-4 text-dark">Hi, Selamat datang kembali!</p>
                <img src="{{ asset('assets/images/logo.svg') }}" alt="TerraScanTrans" style="height: 80px; width: 80px center; margin-top: 30px;">
                <br>
                <br>
                <form class="login-form" action="/login" method="post">
                    @csrf
                    <label for="email" class="fw-bold primary-90">Email</label><br>
                    <input type="text" class="mb-3" placeholder="Masukkan email" id="email" name="email" required>

                    <label for="password" class="fw-bold primary-90">Kata Sandi</label><br>
                    <input type="password" placeholder="Masukkan kata sandi" id="password" name="password" required>
                    
                    @if(isset($error))
                        <span style="color: red;">{{ $error }}</span>
                    @endif

                    <p class="text-end p-0 m-0 fw-bold mb-3"><a href="{{ url('/forget') }}" class="text-danger text-end p-0 m-0 forget">Lupa Password?</a></p>
                    <button type="submit">Log In</button>
                </form>
                <p class="message text-center fw-bold">Tidak punya akun? <a href="{{ url('/signup') }}"> Daftar sekarang</a></p>
            </div>
        </div>
    </div>

    <!-- Javascript files-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <!-- custom javascript -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>
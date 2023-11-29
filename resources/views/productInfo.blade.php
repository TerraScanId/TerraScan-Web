<!DOCTYPE html> 
<html lang="en"> 
  <head> 
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas --> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta name="viewport" content="initial-scale=1, maximum-scale=1"> 
    
    <!-- site metas -->
    <title>Product</title>

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> 
    
    <!--style css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> 
    
    <!-- Responsive--> 
    <link rel="stylesheet"href="{{ asset('assets/css/responsive.css') }}">

    <!-- Icon -->
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}" />

    <!-- Pusher -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <!-- Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> 
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

    <!-- font awesome style -->
    <script src="https://kit.fontawesome.com/ce374c5e5e.js" crossorigin="anonymous"></script>

  </head> 
  
  <!-- body -->
  <body class="main-layout">

    <!-- Chat Box -->
    <button id="toggleChat" class="toggle-button bg-green"><i class="fa-solid fa-message"></i></button> 

    <div id="chatBox-container" class="container rounded hidden p-2"> 
      <div id="chatHeader">
        <h2>Komunitas</h2>
      </div>


      <div class="chat-box">
        @if(Session::has('user'))
        <?php $user = Session::get('user'); ?>

          @if(!empty($chats))
            @foreach($chats as $chat)
              @if($chat['senderId'] == $user['_id'])
                @include('broadcast', ['message' => $chat])
              @else
                @include('receive', ['message' => $chat])
              @endif
            @endforeach
          @else
            <p>Tidak ada pesan.</p>
          @endif

        @else
          <span>Perlu login terlebih dahulu untuk bisa mengirim pesan</span>
        @endif
      </div>
      
      <form id="chatForm">
            @csrf
        <div class="row p-1 m-0 align-items-end"> 

          <div class="col-10 text-start border border-dark rounded p-0 m-0">
            <input type="text" class="form-control" rows="1" id="message" name="message" placeholder="Ketik Pesan...">
            @if(Session::has('user'))
            <?php $user = Session::get('user'); ?>
            <input type="hidden" name="senderId" id="senderId" value="{{ $user['_id'] }}" class="form-control">
            @endif
          </div>

          <div class="col-2 text-end">
          @if(Session::has('user'))
            <button type="submit" class="btn bg-primary-90 btn-hover-primary-10 rounded-circle text-white align-items-center"><i class='bx bxs-send' ></i></button>
          @else
            <button class="btn bg-primary-90 btn-hover-primary-10 rounded-circle text-white align-items-center"><i class='bx bxs-send' ></i></button>
          @endif
          </div>

        </div>
      </form>

    </div>
    <!-- end Chat Box -->

    <!-- header -->
    <header>
      <!-- header inner -->
      <div class="header bg-white">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
              <div class="full">
                <div class="center-desk">
                  <div class="image-container">
                    <a href="{{ url('/') }}">
                      <img src="{{ asset('assets/images/logo.svg') }}" alt="">
                    </a>
                    <a href="{{ url('/') }}" class="c-img2">
                      <img src="{{ asset('assets/images/TerraScan.svg') }}" alt="">
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 p-0 d-flex align-items-center justify-content-end">
              <nav class="navigation navbar navbar-expand-md navbar-dark d-flex align-items-center justify-content-end">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04"
                  aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                  <i class="fa-solid fa-bars" style="color: #000000;"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExample04">
                  <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                      <a class="nav-link" href="{{ url('/') }}"> Beranda </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ url('/about') }}">Tentang</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ url('/product') }}">Produk </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ url('/analyze') }}">Analisis </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ url('/learn') }}">Baca</a>
                    </li>

                    @if(Session::has('user'))
                      <?php $user = Session::get('user'); ?>
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <img src="data:image/png;base64,{{ $user['imageProfile'] }}" style="border-radius: 50%; width: 40px; height: 40px; margin-left: 10px;" alt="">
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="{{ url('/profile') }}">Profil</a>
                              @if($user['accountType'] == 'adminAccount')
                              <a class="dropdown-item" href="{{ url('/dashboard') }}">Dashboard</a>
                              @elseif($user['accountType'] == 'sellerAccount')
                              <a class="dropdown-item" href="{{ url('/requestform') }}">Form Permintaan</a>
                              @endif
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                          </div>
                      </li>
                    @else
                        <li class="nav-item my-2 btn btn-login bg-primary-90 btn-hover-primary-10">
                            <a class="nav-link text-light" href="{{ url('/login') }}">LOGIN</a>
                        </li>
                        <li class="nav-item my-2 btn btn-signup btn-hover-green">
                            <a class="nav-link primary-90 text-hover-light" href="{{ url('/signup') }}">SIGN IN</a>
                        </li>
                    @endif

                  </ul>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!-- end header -->

    <!-- product info -->
    <div class="container">
        <div class="row py-5">
            <div class="col-md-6 col-lg-6 col-sm-12 text-center">
                @if(isset($jsonData[0]['encodeProductImage']))
                    <img src="data:image/png;base64,{{ $jsonData[0]['encodeProductImage'] }}" class="img-fluid rounded float-right img-thumbnail productimg">
                @else
                    <p>Gambar tidak tersedia</p>
                @endif
            </div>
            <div class="col-md-6 col-lg-6 col-sm-6">
                <p class="text-left text-dark fw-bold fs-4">{{ $jsonData[0]['productName'] }}</p>
                <br>
                <p class="text-left neutral-70 fw-bold">Rp {{ $jsonData[0]['productPrice'] }}</p>
                <br>
                <p class="text-left neutral-70 fw-bold">{{ $jsonData[0]['productDesc'] }}</p>
                <br>
                <p class="text-left text-dark fw-bold">Lokasi Penjual</p>
                <p class="text-left neutral-70 fw-bold">{{ $jsonData[0]['seller_info'][0]['sellerLocation'] }}</p>
                <br>
                <a href="https://wa.me/{{ $jsonData[0]['seller_info'][0]['sellerPhoneNumber'] }}?text=Halo, saya tertarik dengan produk {{ $jsonData[0]['productName'] }}, Apakah produk ini masih tersedia?" target="_blank" class="btn text-white bg-primary-90 btn-hover-primary-10"><i class="fa-brands fa-whatsapp"></i> Hubungi Penjual</a>
            </div>
        </div>
    </div>
    <!-- end product info -->

    <!--  footer -->
    <footer>
    <div class="footer bg-primary-90">
        <div class="container">
        <div class="row">
            <div class="col-md-4 px-5 py-2">
            <p class="text-left fw-bold d-block">TerraScan</p>
            <p class="text-left d-block mb-3">© 2023 TerraScan | Galaxy Team</p>
            <a href="https://www.instagram.com/terrascan.id" class="d-inline"><i class="fa-brands fa-instagram fa-lg" style="color: #ffffff;"></i></a>
            <a href="#" class="d-inline mx-3"><i class="fa-brands fa-tiktok fa-lg" style="color: #ffffff;"></i></a>
            <a href="#" class="d-inline"><i class="fa-brands fa-x-twitter fa-lg" style="color: #ffffff;"></i></i></a>
            </div>
            <div class="col-md-4 px-5 py-2">
            <p  class="text-left fw-bold">Halaman</p>
            <a href="{{ url('/') }}"  class="text-left d-block">Beranda</a>
            <a href="{{ url('/about') }}"  class="text-left d-block">Tentang</a>
            <a href="{{ url('/product') }}"  class="text-left d-block">Produk</a>
            <a href="{{ url('/analyze') }}"  class="text-left d-block">Analisis</a>
            <a href="{{ url('/learn') }}"  class="text-left d-block">Baca</a>
            </div>
            <div class="col-md-4 px-5 py-2">
            <p class="text-left fw-bold">Coba aplikasi android kami</p>
            <img src="{{ asset('assets/images/playstore.png') }}" class="playstoreIcon">
            </div>
        </div>
        </div>
    </div>
    </footer>
    <!-- end footer -->

    <!-- Javascript files-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

    <!-- custom javascript -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
      $(document).ready(function() {
        $('.chat-box').scrollTop($('.chat-box')[0].scrollHeight);
      });

      var pusher = new Pusher('e74d8c1b8229078717e6', {
        cluster: 'ap1'
      });

      var channel = pusher.subscribe('chats');

      channel.bind('chatevent', function(data) {
        $.ajax({
          url: "{{ url('/receive') }}",
          method: "POST",
          data: {
            _token: '{{csrf_token()}}',
            message: data.chats,
          },
        })
        .done(function (res) {
          var chatBox = $(".chat-box");
          if (chatBox.find(".msg").length > 0) {
            chatBox.find(".msg").last().after(res);
          } else {
            chatBox.html(res);
          }
          
          chatBox.scrollTop(chatBox[0].scrollHeight);
        });
      });

      $("#chatForm").submit(function (event) {
        event.preventDefault();

        var message = $("form #message").val().trim();

        if (message !== '') {
          var senderId = $("form #senderId").val();

          $.ajax({
            url: 'https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/insertChat',
            method: 'POST',
            data: {
              senderId: senderId,
              message: message
            },
            success: function (response) {
              var dataToBroadcast = {
                _token: '{{csrf_token()}}',
                senderId: response.senderId,
                message: response.message,
                senderName: response.senderName,
                senderProfile: response.senderProfile,
                timestamp: response.timestamp,
                _id: response._id
              };

              $.ajax({
                url: "{{ url('/broadcast') }}",
                method: 'POST',
                headers: {
                  'X-Socket-Id': pusher.connection.socket_id
                },
                data: {
                  _token: '{{csrf_token()}}',
                  message: dataToBroadcast,
                }
              }).done(function (res) {
                var chatBox = $(".chat-box");
                if (chatBox.find(".msg").length > 0) {
                  chatBox.find(".msg").last().after(res);
                } else {
                  chatBox.html(res);
                }

                chatBox.scrollTop(chatBox[0].scrollHeight);

                $("form #message").val('');
              });
            },
            error: function (error) {
              console.error('Error while calling external API:', error);
            }
          });
        }
      });

    </script>

  </body>

</html>
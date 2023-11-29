<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> 
	<link rel="icon" href="{{ asset('assets/images/icon.png') }}" />
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

	<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

	<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
	<title>Admin Dashboard</title>
</head>
<body>
	
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand"><img src="{{ asset('assets/images/logo.svg') }}" class="icon" alt="TerraScan"  style="width: 50px; height: 50px;">TerraScan</a>
		<ul class="side-menu">
			<li><a href="{{ url('/dashboard') }}" class="active"><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
			<li class="divider" data-text="utama">Utama</li>
			<li><a href="{{ url('/productdashboard') }}"><i class='bx bxs-purchase-tag icon' ></i>Produk</a></li>
			<li><a href="{{ url('/productrequest') }}"><i class='bx bxs-envelope icon'></i>Permintaan</a></li>
		</ul>
	</section>
	<!-- SIDEBAR -->

	<!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
            @if(Session::has('user'))
                <?php $user = Session::get('user'); ?>
                <i class='bx bx-menu toggle-sidebar' ></i>
                <form action="#">
                    <div class="form-group">
                    </div>
                </form>
                <a href="#" class="nav-link" id="notifButton" data-toggle="popover" data-placement="bottom">
                    <i class='bx bxs-bell icon'></i>
                    @if($permintaan > 0)
                        <span class="badge">{{ $permintaan }}</span>
                    @endif
                </a>
                <span class="divider"></span>
                <div class="profile">
                    <img src="data:image/png;base64,{{ $user['imageProfile'] }}" alt="">
                    <ul class="profile-link">
                        <li><a href="{{ url('/profile') }}"><i class='bx bxs-user-circle icon' ></i> Profil</a></li>
                        <li><a href="{{ url('/') }}"><i class='bx bxs-home' ></i> Kembali</a></li>
                        <li><a href="{{ url('/logout') }}"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
                    </ul>
                </div>
			@else
                <?php return redirect('login'); ?>
            @endif
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<h1 class="title">Dashboard</h1>

			<div class="info-data">
				<div class="card">
					<div class="head">
						<div>
                            <h2>{{ $pengguna }}</h2>
							<p>Pengguna</p>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2>{{ $produk }}</h2>
							<p>Produk</p>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2>{{ $mitra }}</h2>
							<p>Mitra</p>
						</div>
					</div>
				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2>{{ $permintaan }}</h2>
							<p>Permintaan</p>
						</div>
					</div>
				</div>
			</div>


			<div class="data">
				<div class="content-data">
					<div class="head">
						<h3>Komunitas</h3>
						<div class="menu">
							<i class='bx bx-dots-horizontal-rounded icon'></i>
							<ul class="menu-link">
								<li><a href="{{ url('/deleteallchat') }}">Hapus Seluruh Pesan</a></li>
							</ul>
						</div>
					</div>
					<?php $user = Session::get('user'); ?>
					<div class="chat-box">
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
					</div>
					<form id="chatForm">
						@csrf
						<div class="form-group">
							<textarea class="form-control" style="resize: none;" rows="1" id="message" name="message" placeholder="Ketik Pesan..."></textarea>
							<input type="hidden" name="senderId" id="senderId" value="{{ $user['_id'] }}" class="form-control">
							<button type="submit" class="btn-send text-center"><i class='bx bxs-send' ></i></button>
						</div>
					</form>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	<script src="{{ asset('assets/js/dashboard.js') }}"></script>

	<script>
        var permintaanCount = {{ $permintaan }};
        
        $(document).ready(function(){
            
            $('#notifButton').popover({
                html: true,
                content: function() {
                    return "<div>Terdapat " + permintaanCount + " permintaan yang belum disetujui</div>";
                }
            });

            // Sembunyikan popover saat diklik di luar popover
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#notifButton').length) {
                    $('#notifButton').popover('hide');
                }
            });
        });
    </script>

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

		$("form").submit(function (event) {
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
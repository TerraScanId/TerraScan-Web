<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> 
    <link rel="icon" href="{{ asset('assets/images/icon.png') }}" />
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" type="text/css">
	<title>Request Dashboard</title>
</head>
<body>
	
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand"><img src="{{ asset('assets/images/logo.svg') }}" class="icon" alt="TerraScan"  style="width: 50px; height: 50px;">TerraScan</a>
		<ul class="side-menu">
			<li><a href="{{ url('/dashboard') }}" class=""><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
			<li class="divider" data-text="utama">Utama</li>
			<li><a href="{{ url('/productdashboard') }} " ><i class='bx bxs-purchase-tag icon' ></i>Produk</a></li>
			<li><a href="{{ url('/productrequest') }}" class="active"><i class='bx bxs-envelope icon'></i>Permintaan</a></li>
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
			<h1 class="title"></h1>
            
			<div class="data">
                

                <div class="container">
                    <div class="table-wrapper table-responsive">
                        <div class="table-title">
                            <h2>Permintaan Mitra</h2>
                            <div class="warning-text">
                                Layar terlalu kecil, untuk melakukan aksi disarankan menggunakan desktop
                            </div>
                        </div>
                        <table id="tableRequest" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama Penjual</th>
                                    <th class="text-center">Jenis Permintaan</th>
                                    <th class="text-center d-none d-md-table-cell">Produk</th>
                                    <th class="text-center d-none d-md-table-cell">Detail Permintaan</th>
                                    <th class="text-center d-none d-md-table-cell">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                    <tr>
                                        <td>{{ $request['seller_info']['sellerName'] }}</td>
                                        <td>{{ $request['request'] }}</td>
                                        <td class="d-none d-md-table-cell">{{ $request['productName'] }}</td>
                                        <td class="d-none d-md-table-cell">{{ $request['detail'] }}</td>
                                        <td class="text-center fw-bold d-none d-md-table-cell" style="color:{{ $request['status'] == 'Disetujui' ? '#3CB95B' : ($request['status'] == 'Ditolak' ? '#FB344F' : '#6B7280') }}">
                                            {{ $request['status'] }}
                                        </td>
                                        <td class="text-center fw-bold">
                                            @if($request['status'] != 'Menunggu')
                                                <a href="{{ url('/setnotification', ['requestId' => $request['_id'], 'sellerId' => $request['seller_info']['_id'], 'productId' => $request['productId'], 'action' => 'approve']) }}"
                                                    class="edit" title="Setujui Permintaan" data-toggle="tooltip" style="pointer-events:none; color:grey;">
                                                    <i class="material-icons">&#xE5CA;</i>
                                                </a>
                                                <a href="{{ url('/setnotification', ['requestId' => $request['_id'], 'sellerId' => $request['seller_info']['_id'], 'productId' => $request['productId'], 'action' => 'disapprove']) }}" class="delete"
                                                    title="Tolak Permintaan" data-toggle="tooltip" style="pointer-events:none; color:grey;">
                                                    <i class="material-icons">&#xE5CD;</i>
                                                </a>
                                            @else
                                            <a href="{{ url('/setnotification', ['requestId' => $request['_id'], 'sellerId' => $request['seller_info']['_id'], 'productId' => $request['productId'], 'action' => 'approve']) }}"
                                                    class="edit" title="Setujui Permintaan" data-toggle="tooltip" style="color: #3CB95B;">
                                                    <i class="material-icons">&#xE5CA;</i>
                                            </a>
                                            <a href="{{ url('/setnotification', ['requestId' => $request['_id'], 'sellerId' => $request['seller_info']['_id'], 'productId' => $request['productId'], 'action' => 'disapprove']) }}" class="delete"
                                                title="Tolak Permintaan" data-toggle="tooltip" onclick="return confirm('Tolak permintaan ini?');">
                                                <i class="material-icons">&#xE5CD;</i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
	<script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/product.js') }}"></script>

    <script>new DataTable('#tableRequest');</script>

    <script>
        var permintaanCount = {{ $permintaan }};
        
        $(document).ready(function(){
            // Aktifkan popover saat dokumen sudah siap
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

</body>
</html>
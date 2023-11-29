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
	<title>Product Dashboard</title>
</head>
<body>
	
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand"><img src="{{ asset('assets/images/logo.svg') }}" class="icon" alt="TerraScan"  style="width: 50px; height: 50px;">TerraScan</a>
		<ul class="side-menu">
			<li><a href="{{ url('/dashboard') }}" class=""><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
			<li class="divider" data-text="utama">Utama</li>
			<li><a href="{{ url('/productdashboard') }}" class="active"><i class='bx bxs-purchase-tag icon' ></i>Produk</a></li>
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
			<h1 class="title"></h1>
            
			<div class="data">

            <div class="container">
                <h2>Ubah Produk</h2>
                <form action="/updateproduct" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row py-5">
                        <input type="hidden" name="productId" value="{{ $product[0]['_id'] }}" class="form-control">
                        <input type="hidden" id="previewImageBase64" name="previewImageBase64" value="">
                        <div class="col-md-6 text-center">
                            @if(isset($product[0]['encodeProductImage']))
                                <img src="data:image/png;base64,{{ $product[0]['encodeProductImage'] }}" data-image="{{ $product[0]['encodeProductImage'] }}" id="previewImage" class="img-fluid rounded float-right img-thumbnail productimg">
                                <label for="productImage" class="btn btn-green hover-primary-10 text-light my-3" style="position: relative; overflow: hidden;">
                                    Ubah Foto
                                    <input type="file" class="form-control mb-3" id="productImage" name="productImage" style="position: absolute; top: 0; right: 0; opacity: 0;" onchange="changeImage()">
                                </label>
                            @else
                                <p>Gambar tidak tersedia</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p class="text-left text-dark fw-bold">
                                <label for="productName" class="fw-bold primary-90">Nama Produk</label><br>
                                <input type="text" name="productName" value="{{ $product[0]['productName'] }}" class="form-control">
                            </p>
                            <br>
                            <p class="text-left text-dark fw-bold">
                                <label for="productDesc" class="fw-bold primary-90">Deskripsi Produk</label><br>
                                <textarea name="productDesc" class="form-control" rows="8" cols="50">{{ $product[0]['productDesc'] }}</textarea>
                            </p>
                            <br>
                            <p class="text-left text-dark fw-bold">
                                <label for="productPrice" class="fw-bold primary-90">Harga Produk</label><br>
                                <input type="text" name="productPrice" value="{{ $product[0]['productPrice'] }}" class="form-control">
                            </p>
                            <br>
                            <p class="text-left text-dark fw-bold">
                                <label for="seller" class="fw-bold primary-90">Nama Penjual</label><br>
                                <div class="select-wrapper">
                                    <select name="sellerId" class="form-control">
                                        @foreach ($sellers as $seller)
                                            <option value="{{ $seller['_id'] }}">{{ $seller['sellerName'] }}</option>
                                        @endforeach
                                    </select>
                                    <i class="fa-solid fa-caret-down" style="color: #000000;"></i>
                                </div>
                            </p>
                        </div>
                    </div>
                    @if(isset($error))
                        <span style="color: red;">{{ $error }}</span>
                    @endif
                    <div class="text-center">
                        <button type="submit" class="btn btn-green hover-primary-10 text-light">Simpan Perubahan</button>
                    </div>
                </form>

			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/product.js') }}"></script>

    <!-- Internal javascript -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var initialImageBase64 = document.getElementById('previewImage').dataset.image;
            document.getElementById('previewImageBase64').value = initialImageBase64;
        });


        function changeImage() {
            var input = document.getElementById('productImage');
            var preview = document.getElementById('previewImage');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var img = new Image();
                    img.src = e.target.result;

                    img.onload = function () {
                        var width = img.width;
                        var height = img.height;
                        var newDimension = Math.min(width, height);

                        var canvas = document.createElement('canvas');
                        var aspectRatio = 1; 
                        canvas.width = newDimension;
                        canvas.height = newDimension;

                        var context = canvas.getContext('2d');
                        var x = (width - newDimension) / 2;
                        var y = (height - newDimension) / 2;

                        context.drawImage(img, x, y, newDimension, newDimension, 0, 0, canvas.width, canvas.height);

                        preview.src = canvas.toDataURL();
                    };
                };

                reader.readAsDataURL(input.files[0]);
                
            }
        }
    </script>

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
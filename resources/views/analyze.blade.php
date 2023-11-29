<!DOCTYPE html> 
<html lang="en"> 
  <head> 
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas --> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta name="viewport" content="initial-scale=1, maximum-scale=1"> 
    
    <!-- site metas -->
    <title>Analyze</title>

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

    <!-- Tensorflow -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>

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

    <div class="container pt-3">
      <p class="text-left fw-bold  monochrome-black my-2 fs-1">Analisis</p>
      <p class="text-left fw-bold primary-90 my-2 mt-3 fs-6">Grow Green, Live Vibrant!</p>
    </div>

    <!-- Analyze section -->
    <div class="container bg-grey rounded">
        <div class="container my-5 p-1">
            <h3 class="fw-bold neutral-90">Unggah Gambarmu</h3>
            <div class="container-fluid p-4 bg-white rounded">
                <div id="fileInputContainer" class="rounded" draggable="true">
                    <input type="file" id="fileInput" accept="image/*">
                    <label id="browseButton" class="text-center btn bg-primary-90 text-white w-25 btn-hover-primary-10" for="fileInput">
                        <i class="fa-solid fa-upload text-white"></i>
                    </label>
                    <p>klik tombol di atas atau taruh gambarmu disini</p>
                </div>
                <div class="row mt-3">
                    <!-- Preview Image Container -->
                    <div class="col-md-6">
                        <div id="imagePreview">
                            <img id="uploadedImage" style="max-width: 100px;" />
                            <div id="loadingAnimation" class="text-center">
                                <i class="fa-solid fa-circle-notch fa-spin fa-3x" style="color: #5da800;"></i>
                                <p>Loading...</p>
                            </div>
                        </div>
                        <div id="loadingAnimation" class="text-center">
                            <i class="fa-solid fa-circle-notch fa-spin fa-3x" style="color: #5da800;"></i>
                            <p>Loading...</p>
                        </div>
                    </div>

                    <!-- Form Input Parameter Container -->
                    <div class="col-md-6 parameterBox">
                        <h1 class="text-dark text-center">Input Parameter</h1> 
                        <form action="#" method="POST">
                            <p>Kota</p>
                            <select id="kota" name="kota" required>
                              <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                              <option value="Bandung">Bandung</option>
                              <option value="Banjar">Banjar</option>
                              <option value="Bekasi">Bekasi</option>
                              <option value="Bogor">Bogor</option>
                              <option value="Ciamis">Ciamis</option>
                              <option value="Cianjur">Cianjur</option>
                              <option value="Cirebon">Cirebon</option>
                              <option value="Garut">Garut</option>
                              <option value="Indramayu">Indramayu</option>
                              <option value="Jakarta">Jakarta</option>
                              <option value="Karawang">Karawang</option>
                              <option value="Kuningan">Kuningan</option>
                              <option value="Majalengka">Majalengka</option>
                              <option value="Pangandaran">Pangandaran</option>
                              <option value="Purwakarta">Purwakarta</option>
                              <option value="Subang">Subang</option>
                              <option value="Sukabumi">Sukabumi</option>
                              <option value="Sumedang">Sumedang</option>
                              <option value="Tasikmalaya">Tasikmalaya</option>
                            </select>
                            <br><br>

                            <p>Iklim</p>
                            <select id="iklim" name="iklim" required>
                              <option value="" disabled selected>Pilih Iklim</option>
                              <option value="Musim Panas">Musim Panas</option>
                              <option value="Musim Hujan">Musim Hujan</option>
                            </select>
                            <br><br>
                    
                            <p>pH tanah (opsional)</p>
                            <input type="text" id="ph" name="ph">
                        </form>
                    </div>

                    <div class="col-md-6 resultBox">
                        <div class="analyzeResult">
                            <h2 id="resultHeader" class="text-dark fw-bold fs-3"></h2>
                            <p id="prediction" class="text-dark fw-bold fs-2"></p>
                            <p id="accuracy" class="text-dark mt-2"></p>

                            <div class="row mt-3">
                                <div class="col-6 d-flex align-items-start">
                                    <img id="climateImage" src="{{ asset('assets/images/ic_summer.svg') }}" class="w-25">
                                    <div class="mx-2">
                                        <p id="climateTitle" class="fw-bold">Iklim</p>
                                        <p id="climate" class="text-dark fw-bold"></p>
                                    </div>
                                </div>

                                <div class="col-6 d-flex align-items-start">
                                    <img src="{{ asset('assets/images/ic_temperature.svg') }}" class="w-25">
                                    <div class="mx-2">
                                        <p style="color: #C390E6;" class="fw-bold">Suhu rata-rata</p>
                                        <p id="temperature" class="text-dark fw-bold"></p>
                                    </div>
                                </div>
                            </div>
                            <span class="text-dark fw-bold fs-2 mt-3">Rekomendasi Tanaman</span>
                            <p id="recommendation" class="text-dark"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <button id="submitButton" class="text-center btn text-white bg-primary-90 btn-hover-primary-10 mt-4 w-25">Submit</button>
            </div>
        </div>
        
    </div>
    <!-- Analyze section end -->


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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- custom javascript -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script>
        var appUrl = "{{ url('/') }}";
        var apiUrl = "https://api.openai.com/v1/chat/completions";
        var apiKey = "{{ env('OPENAI_API_KEY') }}";


        let fileInput = $('#fileInput')[0];
        let dropInput;
        var imagePreview = $('#imagePreview')[0];
        const parameterBox = $('.parameterBox');
        const resultBox = $('.resultBox');

        //result
        const resultHeaderElement = $('#resultHeader')[0];
        const predictionElement = $('#prediction')[0];
        const accuracyElement = $('#accuracy')[0];
        const climateElement = $('#climate')[0];
        const temperatureElement = $('#temperature')[0];
        const recommendationElement = $('#recommendation')[0];

        parameterBox.addClass('parameter-hidden');
        resultBox.addClass('parameter-hidden');

        // Load cnn model
        async function loadModel() {
            const model = await tf.loadLayersModel(`${appUrl}/assets/cnn/model.json`);
            return model;
        }

        // Event listener untuk submit button
        $('#submitButton').click(async (event) => {
            $('#submitButton').prop('disabled', true);
            let file;
            if(fileInput.files[0]) {
                file = fileInput.files[0];
            } else if (dropInput) {
                file = dropInput
            }

            // Kondisi tidak ada input file
            if (!file) {
                const noImageMessage = $('<p>').text('Mohon masukkan gambar').css('color', 'red');
                const previousMessage = $(imagePreview).find('p');
                if (previousMessage.length) {
                    previousMessage.remove();
                }
                $(imagePreview).append(noImageMessage);
                $('#submitButton').prop('disabled', false);
                return;
            }

            // Cek apakah tipe file adalah gambar
            if (!file.type.startsWith('image/')) {
                const fileTypeErrorMessage = $('<p>').text('Tipe file tidak valid. Mohon pilih file gambar.').css('color', 'red');
                const previousMessage = $(imagePreview).find('p');
                if (previousMessage.length) {
                    previousMessage.remove();
                }
                $(imagePreview).append(fileTypeErrorMessage);
                $('#submitButton').prop('disabled', false);
                return;
            }

            var kotaInput = $('#kota').val();
            var iklimInput = $('#iklim').val();
            var phInput = $('#ph').val();

            var suhuInput = await getWeather(kotaInput);

            // Mengatur gambar dan warna teks berdasarkan nilai iklimInput
            var climateImage, climateColor;
            if (iklimInput.toLowerCase() === 'musim panas') {
                climateImage = "{{ asset('assets/images/ic_summer.svg') }}";
                climateColor = "#EAC069";
            } else if (iklimInput.toLowerCase() === 'musim hujan') {
                climateImage = "{{ asset('assets/images/ic_rainy.svg') }}";
                climateColor = "#7C95E4";
            } else {
                // Default jika iklimInput tidak cocok dengan kondisi di atas
                climateImage = "{{ asset('assets/images/default_image.svg') }}";
                climateColor = "#000000";
            }

            // Set nilai gambar dan warna teks
            $('#climateTitle').css('color', climateColor);
            $('#climate').html(iklimInput);
            $('#climateImage').attr('src', climateImage);

            // Animasi loading
            const loadingAnimation = $('#loadingAnimation');
            loadingAnimation.css('display', 'block');

            // Load model
            const model = await loadModel();

            const reader = new FileReader();
            reader.onload = async (e) => {
                const image = new Image();
                image.src = e.target.result;

                image.onload = async () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = 150;
                    canvas.height = 150;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(image, 0, 0, 150, 150);

                    const tensor = tf.browser.fromPixels(canvas).toFloat().div(255);
                    const expanded = tensor.expandDims(0);

                    const predictions = await model.predict(expanded).data();
                    const classList = ['Tanah Humus', 'Tanah vulkanik'];

                    const maxPrediction = Math.max(...predictions);
                    const predictedClass = classList[predictions.indexOf(maxPrediction)];
                    const maxPredictionPercentage = (maxPrediction * 100).toFixed(2);

                    console.log('Prediction:', predictions);
                    console.log('Max Prediction:', maxPrediction);

                    const recommendation = await getFinalResult(predictedClass, iklimInput, suhuInput);

                    resultHeaderElement.textContent = 'Hasil: ';
                    predictionElement.textContent = `${predictedClass}`;
                    accuracyElement.textContent = `Akurasi: ${maxPredictionPercentage}%`;
                    climateElement.textContent = `${iklimInput}`;
                    temperatureElement.textContent = `${suhuInput}℃`;
                    recommendationElement.style.whiteSpace = 'pre-line';
                    recommendationElement.textContent = `${recommendation}`

                    parameterBox.addClass('parameter-hidden');
                    resultBox.removeClass('parameter-hidden');

                    // Hide animasi loading
                    loadingAnimation.css('display', 'none');
                    $('#submitButton').prop('disabled', false);
                };
            };

            reader.readAsDataURL(file);
        });


        //Open ai Recommendation
        function getFinalResult(soilResult, seasonParam, temperatureParam) {
            return new Promise((resolve, reject) => {
                var param = "Tanah: " + soilResult + ", Iklim: " + seasonParam + ", Suhu: " + temperatureParam;
                
                var requestData = {
                    model: "gpt-3.5-turbo",
                    messages: [
                        { role: "system", content: "You are a soil expert who has knowledge about soil because you are a professional in that field. You know and can provide recommendations for plants that are suitable for planting in a certain type of soil when someone asks you. With some info provided such as soil type, climate, and average temperature, you can provide plant recommendations based on that information. When answering, please only provide 5 types of plants that are suitable for planting in the ground with this information. Also give a brief explanation of the reason, a maximum of 20 words for each plant. Please note that the plant recommendations you provide must be plants that are suitable for planting in the territory of Indonesia. Then answer the results with Indonesian Language only. Don't answer with English. Are you ready to give accurate plant recommendations? Here is the information:" },
                        { role: "user", content: param }
                    ],
                    max_tokens: 500,
                    top_p: 1,
                    presence_penalty: 1
                };

                $.ajax({
                    url: apiUrl,
                    type: "POST",
                    headers: {
                        "Authorization": "Bearer " + apiKey
                    },
                    contentType: "application/json",
                    data: JSON.stringify(requestData),
                    success: function(response) {
                        var responseContent = response.choices[0].message.content;
                        console.log(responseContent);
                        resolve(responseContent);
                    },
                    error: function(xhr, status, error) {
                        reject(error);
                    }
                });
            });
        }

        // Openweather
        function getWeather(city) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "https://api.openweathermap.org/data/2.5/weather",
                    method: "GET",
                    data: {
                        q: city,
                        appid: "9836446030f7144d1eaf07ed70317df0"
                    },
                    success: function (data) {
                        if (data !== null) {
                            try {
                                var temperatureKelvin = data.main.temp;
                                var temperatureCelcius = temperatureKelvin - 273;

                                var formattedTemperature = temperatureCelcius.toFixed(1);
                                resolve(formattedTemperature.toString());
                            } catch (error) {
                                reject(error);
                            }
                        } else {
                            reject("Gagal mendapatkan data cuaca");
                        }
                    },
                    error: function (xhr, status, error) {
                        reject(error);
                    }
                });
            });
        }


        // Event listener untuk input file
        $(fileInput).change(function () {
            const file = fileInput.files[0];
            if (file) {
                if (!file.type.startsWith('image/')) {
                    const fileTypeErrorMessage = $('<p>').text('Tipe file tidak valid. Mohon pilih file gambar.').css('color', 'red');
                    const previousMessage = $(imagePreview).find('p');
                    if (previousMessage.length) {
                        previousMessage.remove();
                    }
                    $(imagePreview).append(fileTypeErrorMessage);
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    alert('Gambar melebihi 5MB. Mohon pilih gambar yang lebih kecil.');
                    fileInput.value = '';
                } else {
                    const previousMessage = $(imagePreview).find('p');
                    if (previousMessage.length) {
                        previousMessage.remove();
                    }
                    displayImage(file);
                    adjustLayout();
                }
            }
        });

        // Event listener untuk kotak drag & drop
        var dropArea = $('#fileInputContainer')[0];
        dropArea.addEventListener('dragover', function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropArea.style.border = '2px dashed #333';
        });
        dropArea.addEventListener('dragleave', function () {
            dropArea.style.border = '2px dashed #ccc';
        });
        dropArea.addEventListener('drop', function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropArea.style.border = '2px dashed #ccc';

            const file = e.dataTransfer.files[0];
            if (file) {
                if (!file.type.startsWith('image/')) {
                    const fileTypeErrorMessage = $('<p>').text('Tipe file tidak valid. Mohon pilih file gambar.').css('color', 'red');
                    const previousMessage = $(imagePreview).find('p');
                    if (previousMessage.length) {
                        previousMessage.remove();
                    }
                    $(imagePreview).append(fileTypeErrorMessage);
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    alert('Gambar melebihi 5MB. Mohon pilih gambar yang lebih kecil.');
                } else {
                    const previousMessage = $(imagePreview).find('p');
                    if (previousMessage.length) {
                        previousMessage.remove();
                    }
                    dropInput = file
                    displayImage(file);
                    adjustLayout();
                }
            }
        });

        // Fungsi untuk menampilkan gambar
        function displayImage(file) {
            var imageURL = URL.createObjectURL(file);

            var imgElement = $('#uploadedImage')[0];
            imgElement.src = imageURL;
            imgElement.style.maxWidth = '100%';

            // Hapus gambar sebelumnya
            var previousImage = $(imagePreview).find('img');
            if (previousImage.length) {
                previousImage.remove();
            }

            // Tambahkan tombol "Hapus" setelah gambar
            var removeButton = $('<span>').attr('id', 'removeButton').addClass('fa fa-times-circle').css('cursor', 'pointer');
            $(imagePreview).append(imgElement);
            $(imagePreview).append(removeButton);

            // Event listener untuk tombol "Hapus"
            $(removeButton).click(function () {
                fileInput.value = ''; // Menghapus file yang telah dipilih
                imgElement.src = ''; // Menghapus gambar
                removeButton.remove(); // Menghapus tombol "Hapus"
                resultHeaderElement.textContent = ''; // Hapus prediksi jika ada
                predictionElement.textContent = '';
                accuracyElement.textContent = '';
                climateElement.textContent = '';
                temperatureElement.textContent = '';
                resetLayout();
            });
        }

        function adjustLayout() {
            if (fileInput.files[0] || dropInput) {
                parameterBox.removeClass('parameter-hidden');
            }
        }

        function resetLayout() {
            parameterBox.addClass('parameter-hidden');
            resultBox.addClass('parameter-hidden');
        }
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
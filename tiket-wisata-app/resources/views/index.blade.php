<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourism Site</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container-fluid p-0">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <!-- tagline -->
        <div class="jumbotron jumbotron-fluid p-0">
            <div class="hero-image-container">
                <img src="assets/danautoba2.jpeg" class="img-fluid w-100" alt="Nature">
                <div class="hero-overlay"></div>
            </div>
            <div class="container text-white position-absolute top-50 start-50 translate-middle">
                <p class="display-5"><strong>Temukan</strong> Lokasi <strong>Healing</strong> Terbaik</p>
                <p class="display-5">Untukmu dan Keluargamu..</p>
            </div>
        </div>

        <!-- slider coroseul -->
        <div class="container mt-4">
            <div id="destinationsCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($data->chunk(2) as $key => $chunk)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($chunk as $value)
                            <div class="col-md-6">
                                <div class="card rounded shadow-sm">
                                    <img src="assets/{{ $value->gambar }}" class="card-img-top" alt="{{ $value->nama }}">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $value->nama }}</h4>
                                        <div class="col">
                                            <p class="card-text"><i class="bi bi-geo-alt-fill"></i> {{ $value->lokasi }}</p>
                                        </div>
                                        <p class="card-text mt-2"><strong>IDR {{ $value->harga }}</strong></p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#destinationsCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </a>
                <a class="carousel-control-next" href="#destinationsCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
            </div>
        </div>

        <!-- pesan Wisata -->
        <div class="container-fluid d-flex align-items-center justify-content-center p-4">
            <button type="button" class="btn btn-info btn-lg text-light shadow-lg" data-toggle="modal" data-target="#pesanModal">
                Pesan Sekarang
            </button>
        </div>

        <div class="modal fade" id="pesanModal" tabindex="-1" aria-labelledby="pesanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pesanModalLabel">Form Pemesanan Tiket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store')}}" method="POST">
                    @csrf
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="identitas">Nomor Identitas</label>
                            <input type="text" name="identitas" class="form-control" id="identitas" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="no_hp">Nomor HP</label>
                            <input type="text" name="no_hp" class="form-control" id="no_hp" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="tempat">Tempat Wisata</label>
                            <select class="form-control" id="tempat" name="tempat">
                                @foreach ($data as $key => $value)
                                    <option value="{{ $value->id }}" data-harga="{{ $value->harga }}">{{ $value->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Pemesanan</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
                        </div>
                        <div class="form-group">
                            <label for="dewasa">Pengunjung Dewasa</label>
                            <input type="number" class="form-control" id="dewasa" name="dewasa" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="anak">Pengunjung Anak-anak <small>(usia dibawah 12 tahun)</small></label>
                            <input type="number" class="form-control" id="anak" name="anak" placeholder="">
                        </div>
                </div>
                <div class="row justify-content-start container">
                    <div class="col-12">
                        <span>Harga Tiket : Rp <span id="harga-tiket"></span></span>
                    </div>
                    <div class="col-12">
                        <span>Total Bayar: Rp <span id="total-bayar"></span></span>
                    </div>
                    <input type="hidden" name="total-bayar" id="hidden-total-bayar">
                </div>

                <div class="form-group container mt-4 mb-2">
                    <label for="baca"><input type="checkbox" name="baca" id="baca"> Saya dan/atau rombongan telah membaca, memahami dan setuju berdasarkan syarat dan ketentuan yang ditetapkan</label>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="hitungTotalBayar()">Hitung Total Bayar</button>
                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#konfirmasiTiket">Pesan Tiket</button>

                    <!-- Modal untuk detail Pesanan -->
                    <div class="modal fade" id="konfirmasiTiket" tabindex="-1" aria-labelledby="konfirmasiTiketLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="konfirmasiTiketLabel">Detail Pesanan Tiket</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Nama:</strong> <span id="konfirmasi-nama"></span></p>
                                    <p><strong>Nomor Identitas:</strong> <span id="konfirmasi-identitas"></span></p>
                                    <p><strong>Nomor HP:</strong> <span id="konfirmasi-no_hp"></span></p>
                                    <p><strong>Tempat Wisata:</strong> <span id="konfirmasi-tempat"></span></p>
                                    <p><strong>Tanggal Pemesanan:</strong> <span id="konfirmasi-tanggal"></span></p>
                                    <p><strong>Pengunjung Dewasa:</strong> <span id="konfirmasi-dewasa"></span></p>
                                    <p><strong>Pengunjung Anak-anak:</strong> <span id="konfirmasi-anak"></span></p>
                                    <p><strong>Total Bayar:</strong> Rp <span id="konfirmasi-total-bayar"></span></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                                    <button type="button" class="btn btn-primary" id="konfirmasi-pesan">Pesan Tiket</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // hitung harga tiket berdasarkan tempat wisata
        const tempatSelect = document.getElementById('tempat');
        const hargaTiketSpan = document.getElementById('harga-tiket');

        tempatSelect.addEventListener('change', function() {
            const harga = this.options[this.selectedIndex].getAttribute('data-harga');
            hargaTiketSpan.textContent = harga;
        });


        // hitung total bayar tiket
        function hitungTotalBayar() {
        const tempatSelect = document.getElementById('tempat');
        const dewasaInput = document.getElementById('dewasa').value;
        const anakInput = document.getElementById('anak').value;
        const hargaTiket = tempatSelect.options[tempatSelect.selectedIndex].getAttribute('data-harga');
        // console.log(hargaTiket)
        
        // cek apakah data sudah terisi
        if (tempatSelect.value === '' || dewasaInput === '' && anakInput === '') {
            alert('Data pemesanan belum lengkap');
            return;
        }

        const totalDewasa = dewasaInput * hargaTiket;
        const totalAnak = anakInput * (hargaTiket / 2); 
        const totalBayar = totalDewasa + totalAnak +'.000';
        // console.log(totalDewasa)

        // tampilkan hasil total bayar
        const totalBayarSpan = document.getElementById('total-bayar');
        totalBayarSpan.textContent = `${totalBayar}`;

        const inputHidden = document.getElementById('hidden-total-bayar');
        inputHidden.value = totalBayar;
    }

        // konfirmasi pemesanan tiket
        document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
        event.preventDefault();

        const nama = document.getElementById('nama').value;
        const identitas = document.getElementById('identitas').value;
        const no_hp = document.getElementById('no_hp').value;
        const tempat = document.getElementById('tempat').options[document.getElementById('tempat').selectedIndex].text;
        const tanggal = document.getElementById('tanggal').value;
        const dewasa = document.getElementById('dewasa').value;
        const anak = document.getElementById('anak').value;
        const totalBayar = document.getElementById('hidden-total-bayar').value;

        document.getElementById('konfirmasi-nama').textContent = nama;
        document.getElementById('konfirmasi-identitas').textContent = identitas;
        document.getElementById('konfirmasi-no_hp').textContent = no_hp;
        document.getElementById('konfirmasi-tempat').textContent = tempat;
        document.getElementById('konfirmasi-tanggal').textContent = tanggal;
        document.getElementById('konfirmasi-dewasa').textContent = dewasa;
        document.getElementById('konfirmasi-anak').textContent = anak;
        document.getElementById('konfirmasi-total-bayar').textContent = totalBayar;

        // Tampilkan 
        $('#konfirmasiTiket').modal('show');
    });

    // Ketika konfirmasi di modal konfirmasi ditekan
    document.getElementById('konfirmasi-pesan').addEventListener('click', function() {
        document.querySelector('form').submit();
    });

    </script>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

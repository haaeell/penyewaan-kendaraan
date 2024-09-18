@extends('layouts.landingpage')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mb-3">
                <div class="card shadow border-0">
                    <div class="card-header">
                        <h5 class="fw-semibold">Data Pemesan</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama</th>
                                <td>{{ Auth::user()->wisatawan->nama }}</td>
                            </tr>
                            <tr>
                                <th>No Telepon</th>
                                <td>{{ Auth::user()->wisatawan->no_telepon }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ Auth::user()->wisatawan->alamat }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shadow border-0 mt-3">
                    <div class="card-header">
                        <h5 class="fw-semibold">Data Kendaraan</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="form-label mt-4">Data Kendaraan</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th>Nama Kendaraan</th>
                                <td>{{ $kendaraan->nama }}</td>
                            </tr>
                            <tr>
                                <th>Jenis</th>
                                <td>{{ $kendaraan->jenis }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ $kendaraan->type }}</td>
                            </tr>
                            <tr>
                                <th>Plat Nomor</th>
                                <td>{{ $kendaraan->plat_nomor }}</td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>{{ $kendaraan->keterangan }}</td>
                            </tr>
                            <tr>
                                <th>Tahun</th>
                                <td>{{ $kendaraan->tahun }}</td>
                            </tr>
                            @if ($kendaraan->seating_capacity)
                                <tr>
                                    <th>Kapasitas Tempat Duduk</th>
                                    <td>{{ $kendaraan->seating_capacity }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th>Merk</th>
                                <td>{{ $kendaraan->merk }}</td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>Rp {{ number_format($kendaraan->harga, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Foto</th>
                                <td><img src="{{ $kendaraan->foto ? asset('storage/' . $kendaraan->foto) : 'https://via.placeholder.com/120' }}"
                                        alt="{{ $kendaraan->nama }}" class="img-fluid" style="max-width: 200px;"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="card-header">
                        <h4 class="text-center fw-semibold">Formulir Pemesanan</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('sewa.store') }}" id="orderForm" method="POST">
                            @csrf
                            <input type="hidden" name="kendaraan_id" value="{{ $kendaraan->id }}">

                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                <input type="datetime-local" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="datetime-local" class="form-control" id="tanggal_selesai"
                                    name="tanggal_selesai" required>
                            </div>
                            <input type="hidden" id="jumlah_hari" name="jumlah_hari">
                            <div class="mb-3">
                                <label for="metode_pickup" class="form-label">Metode Pickup</label>
                                <select class="form-select" id="metode_pickup" name="metode_pickup" required>
                                    <option value="">Pilih Metode</option>
                                    <option value="ambil_sendiri">Ambil Sendiri</option>
                                    <option value="diantar">Diantar</option>
                                </select>
                            </div>
                            <div class="mb-3" id="lokasi_pickup_section" style="display: none;">
                                <label for="lokasi_pickup" class="form-label">Lokasi Pickup</label>
                                <textarea class="form-control" id="lokasi_pickup" name="lokasi_pickup"
                                    placeholder="Klik pada peta untuk memilih lokasi"></textarea>
                                <div id="map" style="height: 250px; margin-top: 10px;"></div>
                            </div>
                            <div class="mb-3" id="lokasi_perusahaan_section" style="display: none;">
                                <label for="lokasi_perusahaan" class="form-label">Lokasi Perusahaan</label>

                                <input type="text" class="form-control" name="lokasi_perusahaan" value="Jl Yogyakarta"  readonly>
                                
                                <input type="hidden" class="form-control" id="lokasi_perusahaan" name="lokasi_perusahaan" value="0,0" readonly>
                                <div id="mapPerusahaan" style="height: 250px; margin-top: 10px;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                                <select class="form-select" id="jenis_pembayaran" name="jenis_pembayaran" required>
                                    <option value="">Pilih Jenis Pembayaran</option>
                                    @foreach ($jenisPembayaran as $pembayaran)
                                        <option value="{{ $pembayaran->id }}">{{ $pembayaran->nama }} - No rek:
                                            {{ $pembayaran->no_rek }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="kode_promo" class="form-label">Kode Promo</label>
                                <input type="text" class="form-control" id="kode_promo" name="kode_promo">
                                <div id="kode_promo_error" class="text-danger" style="display: none;">Kode promo tidak ada
                                </div>
                                <div id="potongan_promo_message" class="text-success" style="display: none;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="total_harga" class="form-label">Total Harga</label>
                                <input type="text" class="form-control" id="total_harga" name="total_harga" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="total_harga_setelah_diskon" class="form-label">Total Harga Setelah Diskon</label>
                                <input type="text" class="form-control" id="total_harga_setelah_diskon" name="total_harga_setelah_diskon" readonly>
                            </div>

                            <button type="button" class="btn btn-primary text-white fw-semibold" onclick="confirmSubmit()">Kirim Pesanan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Include Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmSubmit() {
            Swal.fire({
                title: 'Konfirmasi Pengiriman',
                text: "Apakah Anda yakin ingin mengirim pesanan?",
                icon: 'primary',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('orderForm').submit(); // Kirim formulir jika konfirmasi
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            var metodePickupSelect = document.getElementById('metode_pickup');
            var lokasiPickupSection = document.getElementById('lokasi_pickup_section');
            var lokasiPerusahaanSection = document.getElementById('lokasi_perusahaan_section');
            var mapElement = document.getElementById('map');
            var mapPerusahaanElement = document.getElementById('mapPerusahaan');
            var lokasiPickupInput = document.getElementById('lokasi_pickup');
            var lokasiPerusahaanInput = document.getElementById('lokasi_perusahaan');

            var map, mapPerusahaan, marker, markerPerusahaan;

            function initializeMap() {
                if (mapElement && !map) {
                    map = L.map(mapElement).setView([-7.786567157220733,110.40142819793935], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    marker = L.marker([-7.7956, 110.3695], {
                        draggable: true
                    }).addTo(map);

                    marker.on('dragend', function(e) {
                        var latlng = marker.getLatLng();
                        lokasiPickupInput.value = latlng.lat + ', ' + latlng.lng;
                    });

                    map.on('click', function(e) {
                        marker.setLatLng(e.latlng);
                        lokasiPickupInput.value = e.latlng.lat + ', ' + e.latlng.lng;
                    });
                }
            }

            function initializeMapPerusahaan() {
                if (mapPerusahaanElement && !mapPerusahaan) {
                    mapPerusahaan = L.map(mapPerusahaanElement).setView([-7.7956, 110.3695], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(mapPerusahaan);

                    var perusahaanLocation = [-7.7956, 110.3695]; // Coordinate for Yogyakarta

                    markerPerusahaan = L.marker(perusahaanLocation, {
                        draggable: false
                    }).addTo(mapPerusahaan);

                    lokasiPerusahaanInput.value = perusahaanLocation[0] + ', ' + perusahaanLocation[1];
                }
            }

            metodePickupSelect.addEventListener('change', function() {
                var metode = this.value;
                if (metode === 'ambil_sendiri') {
                    lokasiPerusahaanSection.style.display = 'block';
                    lokasiPickupSection.style.display = 'none';
                    initializeMapPerusahaan();
                } else {
                    lokasiPickupSection.style.display = 'block';
                    lokasiPerusahaanSection.style.display = 'none';
                    initializeMap();
                }
            });

            document.getElementById('tanggal_mulai').addEventListener('change', hitungJumlahHari);
            document.getElementById('tanggal_selesai').addEventListener('change', hitungJumlahHari);

            function hitungJumlahHari() {
                var tanggalMulai = document.getElementById('tanggal_mulai').value;
                var tanggalSelesai = document.getElementById('tanggal_selesai').value;

                if (tanggalMulai && tanggalSelesai) {
                    var mulai = new Date(tanggalMulai);
                    var selesai = new Date(tanggalSelesai);

                    var timeDiff = selesai.getTime() - mulai.getTime();
                    var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

                    document.getElementById('jumlah_hari').value = daysDiff;
                    hitungTotalHarga(daysDiff);
                }
            }

            var hargaKendaraan = {{ $kendaraan->harga }};

            function hitungTotalHarga(jumlahHari) {
                var totalHarga = hargaKendaraan * jumlahHari;
                document.getElementById('total_harga').value = 'Rp ' + totalHarga.toLocaleString('id-ID');
                document.getElementById('total_harga_setelah_diskon').value = 'Rp ' + totalHarga.toLocaleString('id-ID');
            }
        });

        function applyPromoCode() {
            var kodePromoInput = document.getElementById('kode_promo');
            var promoCode = kodePromoInput.value.trim();

            if (promoCode === '') {
                document.getElementById('kode_promo_error').style.display = 'block';
                document.getElementById('potongan_promo_message').style.display = 'none';
                return;
            }

            fetch('/cek-kode-promo', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ kode_promo: promoCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.valid) {
                    document.getElementById('kode_promo_error').style.display = 'none';
                    document.getElementById('potongan_promo_message').style.display = 'block';
                    document.getElementById('potongan_promo_message').innerHTML = 'Potongan promo: Rp ' + data.potongan.toLocaleString('id-ID');
                    hitungTotalHargaPromo(data.potongan);
                } else {
                    document.getElementById('kode_promo_error').style.display = 'block';
                    document.getElementById('potongan_promo_message').style.display = 'none';
                }
            });
        }

        function hitungTotalHargaPromo(potongan) {
            var totalHarga = hargaKendaraan * parseInt(document.getElementById('jumlah_hari').value);
            var totalHargaSetelahDiskon = totalHarga - potongan;

            document.getElementById('total_harga').value = 'Rp ' + totalHarga.toLocaleString('id-ID');
            document.getElementById('total_harga_setelah_diskon').value = 'Rp ' + totalHargaSetelahDiskon.toLocaleString('id-ID');
        }

        document.getElementById('kode_promo').addEventListener('blur', applyPromoCode);
    </script>
@endsection

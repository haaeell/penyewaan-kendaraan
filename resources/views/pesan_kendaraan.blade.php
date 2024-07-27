@extends('layouts.landingpage')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 mb-3">
           <div class="card shadow border-0">
           <div class="card-header">
               <h5 class="fw-semibold ">Data Pemesan</h5>
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
                <h5 class="fw-semibold ">Data Kendaraan</h5>
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
                    <tr>
                        <th>Kapasitas Tempat Duduk</th>
                        <td>{{ $kendaraan->seating_capacity }}</td>
                    </tr>
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
                        <td><img src="{{ $kendaraan->foto ? asset('storage/' . $kendaraan->foto) : 'https://via.placeholder.com/120' }}" alt="{{ $kendaraan->nama }}" class="img-fluid" style="max-width: 200px;"></td>
                    </tr>
                </table>
            </div>
          </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow border-0 ">
                <div class="card-header">
                    <h4 class="text-center fw-semibold">Formulir Pemesanan</h4>
                </div>
                <div class="card-body">
                  
                    <form action="{{ route('sewa.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kendaraan_id" value="{{ $kendaraan->id }}">
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                        </div>
                        <div class="mb-3">
                            <label for="metode_pickup" class="form-label">Metode Pickup</label>
                            <select class="form-select" id="metode_pickup" name="metode_pickup" required>
                                <option value="ambil_sendiri">Ambil Sendiri</option>
                                <option value="diantar">Diantar</option>
                            </select>
                        </div>
                        <div class="mb-3" id="lokasi_pickup_section" style="display: none;">
                            <label for="lokasi_pickup" class="form-label">Lokasi Pickup</label>
                            <textarea class="form-control" id="lokasi_pickup" name="lokasi_pickup" placeholder="Klik pada peta untuk memilih lokasi"></textarea>
                            <div id="map" style="height: 250px; margin-top: 10px;"></div>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran</label>
                            <select class="form-select" id="jenis_pembayaran" name="jenis_pembayaran" required>
                                <option value="">Pilih Jenis Pembayaran</option>
                                @foreach($jenisPembayaran as $pembayaran)
                                    <option value="{{ $pembayaran->id }}">
                                        {{ $pembayaran->nama }} - No rek: {{ $pembayaran->no_rek }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning text-white fw-semibold">Kirim Pesanan</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var metodePickupSelect = document.getElementById('metode_pickup');
        var lokasiPickupSection = document.getElementById('lokasi_pickup_section');
        var mapElement = document.getElementById('map');
        var map;
        var marker;

        metodePickupSelect.addEventListener('change', function() {
            if (metodePickupSelect.value === 'diantar') {
                lokasiPickupSection.style.display = 'block';
                initializeMap();
            } else {
                lokasiPickupSection.style.display = 'none';
            }
        });

        function initializeMap() {
            if (map) {
                map.remove();
            }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    map = L.map('map').setView([lat, lng], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    marker = L.marker([lat, lng]).addTo(map);

                    map.on('click', function(e) {
                        var latlng = e.latlng;
                        marker.setLatLng(latlng);
                        document.getElementById('lokasi_pickup').value = 'Lat: ' + latlng.lat + ', Lng: ' + latlng.lng;
                    });
                }, function() {
                    alert('Lokasi Anda tidak dapat ditemukan. Mohon izinkan akses lokasi pada browser Anda.');
                });
            } else {
                alert('Geolocation tidak didukung oleh browser Anda.');
            }
        }
    });
</script>
@endsection

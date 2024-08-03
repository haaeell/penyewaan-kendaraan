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
                            <input type="datetime-local" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="datetime-local" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                        </div>
                        <input type="hidden" id="jumlah_hari" name="jumlah_hari">
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
                                @foreach ($jenisPembayaran as $pembayaran)
                                    <option value="{{ $pembayaran->id }}">{{ $pembayaran->nama }} - No rek: {{ $pembayaran->no_rek }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kode_promo" class="form-label">Kode Promo</label>
                            <input type="text" class="form-control" id="kode_promo" name="kode_promo">
                            <div id="kode_promo_error" class="text-danger" style="display: none;">Kode promo tidak ada</div>
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
    var mapElement = document.getElementById('map');
    var map;
    var marker;
    var hargaAwal = parseFloat({{ $kendaraan->harga }});
    const kodePromoInput = document.getElementById('kode_promo');
    const kodePromoError = document.getElementById('kode_promo_error');
    const potonganPromoMessage = document.getElementById('potongan_promo_message');
    const totalHargaInput = document.getElementById('total_harga');
    const totalHargaSetelahDiskonInput = document.getElementById('total_harga_setelah_diskon');

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
                var userLocation = [position.coords.latitude, position.coords.longitude];
                map = L.map('map').setView(userLocation, 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                marker = L.marker(userLocation, {
                    draggable: true
                }).addTo(map);

                marker.on('dragend', function(e) {
                    var position = marker.getLatLng();
                    document.getElementById('lokasi_pickup').value = position.lat + ', ' + position.lng;
                });

                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    document.getElementById('lokasi_pickup').value = e.latlng.lat + ', ' + e.latlng.lng;
                });
            });
        }
    }

    kodePromoInput.addEventListener('input', function() {
        let kodePromo = kodePromoInput.value;
        let totalHarga = parseFloat(totalHargaInput.value.replace(/[^0-9]/g, '')) || hargaAwal;
        let hargaAkhir = totalHarga;

        if (kodePromo.length > 0) {
            fetch(`/check-promo/${kodePromo}`)
                .then(response => response.json())
                .then(data => {
                    if (data.valid) {
                        kodePromoError.style.display = 'none';
                        potonganPromoMessage.style.display = 'block';
                        if (data.jenis === 'diskon_persen') {
                            let diskon = hargaAkhir * (data.nilai / 100);
                            hargaAkhir -= diskon;
                            potonganPromoMessage.innerText = `Diskon ${data.nilai}%: -Rp ${diskon.toLocaleString('id-ID')}`;
                        } else if (data.jenis === 'potongan_harga') {
                            hargaAkhir -= data.nilai;
                            potonganPromoMessage.innerText = `Potongan harga: -Rp ${data.nilai.toLocaleString('id-ID')}`;
                        }
                        totalHargaSetelahDiskonInput.value = `Rp ${hargaAkhir.toLocaleString('id-ID')}`;
                    } else {
                        kodePromoError.style.display = 'block';
                        potonganPromoMessage.style.display = 'none';
                        totalHargaSetelahDiskonInput.value = `Rp ${hargaAkhir.toLocaleString('id-ID')}`;
                    }
                });
        } else {
            kodePromoError.style.display = 'none';
            potonganPromoMessage.style.display = 'none';
            totalHargaSetelahDiskonInput.value = `Rp ${hargaAkhir.toLocaleString('id-ID')}`;
        }
    });

    document.getElementById('tanggal_mulai').addEventListener('change', updateTotalHarga);
    document.getElementById('tanggal_selesai').addEventListener('change', updateTotalHarga);

    function updateTotalHarga() {
        let tanggalMulai = document.getElementById('tanggal_mulai').value;
        let tanggalSelesai = document.getElementById('tanggal_selesai').value;

        if (tanggalMulai && tanggalSelesai) {
            let mulai = new Date(tanggalMulai);
            let selesai = new Date(tanggalSelesai);
            let selisihWaktu = selesai - mulai;
            let selisihHari = Math.ceil(selisihWaktu / (1000 * 60 * 60 * 24)); // Calculate days

            if (selisihWaktu > 0) {
                let totalHarga = hargaAwal * selisihHari;
                totalHargaInput.value = `Rp ${totalHarga.toLocaleString('id-ID')}`;

                // Update total harga setelah diskon jika ada kode promo
                let hargaSetelahDiskon = totalHarga;
                if (kodePromoInput.value) {
                    let kodePromo = kodePromoInput.value;
                    fetch(`/check-promo/${kodePromo}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.valid) {
                                if (data.jenis === 'diskon_persen') {
                                    let diskon = hargaSetelahDiskon * (data.nilai / 100);
                                    hargaSetelahDiskon -= diskon;
                                } else if (data.jenis === 'potongan_harga') {
                                    hargaSetelahDiskon -= data.nilai;
                                }
                                totalHargaSetelahDiskonInput.value = `Rp ${hargaSetelahDiskon.toLocaleString('id-ID')}`;
                            } else {
                                totalHargaSetelahDiskonInput.value = `Rp ${hargaSetelahDiskon.toLocaleString('id-ID')}`;
                            }
                        });
                } else {
                    totalHargaSetelahDiskonInput.value = `Rp ${hargaSetelahDiskon.toLocaleString('id-ID')}`;
                }
            } else {
                document.getElementById('jumlah_hari').value = '';
                totalHargaInput.value = 'Rp 0';
                totalHargaSetelahDiskonInput.value = 'Rp 0';
            }
        }
    }
});
</script>
@endsection

@extends('layouts.landingpage')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Filter Section -->
        <div class="col-md-2 mt-4">
            <form action="{{ route('daftarKendaraan') }}" method="GET">
                <div class="mb-3">
                    <label for="jenis" class="form-label fw-semibold">Filter Jenis Kendaraan</label>
                    <select name="jenis" id="jenis" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Jenis</option>
                        <option value="mobil" {{ request('jenis') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                        <option value="motor" {{ request('jenis') == 'motor' ? 'selected' : '' }}>Motor</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="merk" class="form-label fw-semibold">Filter Merk Kendaraan</label>
                    <select name="merk" id="merk" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Merk</option>
                        @foreach($merks as $key => $value)
                            <option value="{{ $key }}" {{ request('merk') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Kendaraan List -->
        <div class="col-md-10">
            <h4 class="mb-4 text-center fw-semibold">Daftar Kendaraan</h4>
            <div class="row">
                @foreach($kendaraans as $kendaraan)
                    <div class="col-md-4 mb-4">
                        <div class="d-flex align-items-center p-2 rounded-3 shadow-md" style="border: 1px solid rgb(0, 128, 248)">
                            <img src="{{ $kendaraan->foto ? asset('storage/' . $kendaraan->foto) : 'https://via.placeholder.com/120' }}" class="img-fluid" alt="{{ $kendaraan->nama }}" style="width: 120px; height: 120px; object-fit: cover;">

                            <div class="ms-2">
                                <h5 class="fs-6">{{ $kendaraan->nama }}</h5>
                                <p class="small">Rp {{ number_format($kendaraan->harga, 0, ',', '.') }}/ Hari</p>
                                <p class="small">{{ $kendaraan->tahun }}</p>
                                <a href="{{ route('detailKendaraan', $kendaraan->id) }}" class="btn btn-primary text-white w-100 btn-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

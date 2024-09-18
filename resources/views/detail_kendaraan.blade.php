@extends('layouts.landingpage')

@section('content')
<div class="container py-5 min-vh-100">
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <img src="{{ $kendaraan->foto ? asset('storage/' . $kendaraan->foto) : 'https://via.placeholder.com/120' }}"
                    width="100%" class="rounded-4" alt="">
            </div>
            <div class="col-md-7">
                <div>
                    <h3 class="fw-semibold">{{ $kendaraan->nama }}</h3>
                    <p class="m-0">Tahun {{ $kendaraan->tahun }} - Type {{ $kendaraan->type }}</p>
                    <p class="mt-3 mb-0">{{ $kendaraan->keterangan }} Pengantaran Kendaraan Sangat Cepat dan Kendaraan Dalam Keadaan 
                        Yang Sangat Bersih.</p>
                    <p class="mt-0 mb-2 text-secondary">Seating capacity : {{ $kendaraan->seating_capacity }}</p>
                    <span class="fw-bold fs-5 text-danger">Rp
                        {{ number_format($kendaraan->harga, 0, ',', '.') }}/Hari</span>
                </div>

                @if (Auth::check())
                <a href="{{ route('sewa.create', ['kendaraan_id' => $kendaraan->id]) }}"
                    class="btn btn-primary text-white fw-semibold fs-6 btn-sm mt-3 py-2">Pesan Sekarang</a>
                @else
                <a class="btn btn-primary text-white fw-semibold fs-6 btn-sm mt-3 py-2" data-bs-toggle="modal"
                    data-bs-target="#loginModal">Pesan Sekarang</a>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection

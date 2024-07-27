@extends('layouts.landingpage')

@section('content')
    <div class="card shadow border-0 py-5 min-vh-100">
        <div class="container">
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
                            <p class="mt-3 mb-0">{{ $kendaraan->keterangan }} Lorem ipsum, dolor sit amet consectetur adipisicing elit. Soluta nam facere facilis quo? Omnis ex nulla accusantium perspiciatis, qui explicabo.</p>
                            <p class="mt-0 mb-2 text-secondary">Seating capacity : {{ $kendaraan->seating_capacity }}</p>
                            <span class="fw-bold fs-5 text-danger">Rp
                                {{ number_format($kendaraan->harga, 0, ',', '.') }}/Hari</span>
                        </div>

                        <a href="{{ route('sewa.create', ['kendaraan_id' => $kendaraan->id]) }}"
                            class="btn btn-warning text-white fw-semibold fs-6 btn-sm mt-3 py-2">Pesan Sekarang</a>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

<!-- resources/views/jenis_pembayaran/edit.blade.php -->

@extends('layouts.dashboard')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow border-0">
            <div class="card-header">
                <h4 class="fw-semibold text-primary">{{ __('Edit Jenis Pembayaran') }}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('jenis_pembayaran.update', $jenisPembayaran->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $jenisPembayaran->nama) }}" required>
                                @error('nama')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="no_rek">No Rek</label>
                                <input type="text" id="no_rek" name="no_rek" class="form-control @error('no_rek') is-invalid @enderror" value="{{ old('no_rek', $jenisPembayaran->no_rek) }}">
                                @error('no_rek')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="gambar">Gambar</label>
                                <input type="file" id="gambar" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
                                @if($jenisPembayaran->gambar)
                                    <img src="{{ asset('storage/' . $jenisPembayaran->gambar) }}" alt="{{ $jenisPembayaran->nama }}" width="100">
                                @endif
                                @error('gambar')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary text-white">Simpan</button>
                            <a href="{{ route('jenis_pembayaran.index') }}" class="btn btn-sm btn-secondary text-white ">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

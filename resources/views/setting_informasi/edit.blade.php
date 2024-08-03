@extends('layouts.dashboard')

@section('content')
<div class="container">
   <div class="card shadow border-0">
    <div class="card-body">
        <h2 class="fw-semibold"> Setting Informasi</h2>
        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <label for="logo" class="col-md-4 col-form-label text-md-end">Logo</label>
                <div class="col-md-6">
                    <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo">
                    @error('logo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="nama_perusahaan" class="col-md-4 col-form-label text-md-end">Nama Perusahaan</label>
                <div class="col-md-6">
                    <input id="nama_perusahaan" type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror" name="nama_perusahaan" value="{{ old('nama_perusahaan', $settings->nama_perusahaan) }}" required>
                    @error('nama_perusahaan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $settings->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="no_telepon" class="col-md-4 col-form-label text-md-end">No Telepon</label>
                <div class="col-md-6">
                    <input id="no_telepon" type="text" class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon" value="{{ old('no_telepon', $settings->no_telepon) }}" required>
                    @error('no_telepon')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-3">
                <label for="alamat" class="col-md-4 col-form-label text-md-end">Alamat</label>
                <div class="col-md-6">
                    <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required>{{ old('alamat', $settings->alamat) }}</textarea>
                    @error('alamat')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
    
            <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary text-white">
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
   </div>
</div>
@endsection

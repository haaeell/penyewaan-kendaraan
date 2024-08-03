@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="card border-0 shadow">
        <div class="card-body">
            <h2 class="fw-semibold">Setting Informasi</h2>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6">
            <h4>Logo</h4>
            @if($settings->logo)
                <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" class="img-fluid" style="max-width: 200px;">
            @else
                <p>No logo uploaded.</p>
            @endif
        </div>
        <div class="col-md-6">
            <a href="{{ route('settings.edit') }}" class="btn btn-primary text-white">Edit Settings</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h4>Nama Perusahaan</h4>
            <p>{{ $settings->nama_perusahaan }}</p>
        </div>
        <div class="col-md-6">
            <h4>Email</h4>
            <p>{{ $settings->email }}</p>
        </div>
        <div class="col-md-6">
            <h4>No Telepon</h4>
            <p>{{ $settings->no_telepon }}</p>
        </div>
        <div class="col-md-12">
            <h4>Alamat</h4>
            <p>{{ $settings->alamat }}</p>
        </div>
    </div>
        </div>
    </div>
</div>
@endsection

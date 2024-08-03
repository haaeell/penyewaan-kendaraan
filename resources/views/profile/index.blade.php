@extends('layouts.landingpage')

@section('content')
<div class="card border-0 min-vh-100">
    <div class="card-body">
        <div class="container">
            <h2 class="fw-semibold text-center mb-5">Profile Settings</h2>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-md-2 col-form-label">{{ __('Name') }}</label>
                    <div class="col-md-4">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <label for="email" class="col-md-2 col-form-label">{{ __('Email Address') }}</label>
                    <div class="col-md-4">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="no_telepon" class="col-md-2 col-form-label">{{ __('No Telepon') }}</label>
                    <div class="col-md-4">
                        <input id="no_telepon" type="text" class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon" value="{{ old('no_telepon', $wisatawan->no_telepon ?? '') }}" required>
                        @error('no_telepon')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <label for="alamat" class="col-md-2 col-form-label">{{ __('Alamat') }}</label>
                    <div class="col-md-4">
                        <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required>{{ old('alamat', $wisatawan->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="ktp" class="col-md-2 col-form-label">{{ __('KTP') }}</label>
                    <div class="col-md-4">
                        <input id="ktp" type="file" class="form-control @error('ktp') is-invalid @enderror" name="ktp" accept="image/*" onchange="previewFile(this, 'ktp-preview')">
                        @if($wisatawan && $wisatawan->ktp)
                            <img id="ktp-preview" src="{{ asset('storage/'.$wisatawan->ktp) }}" alt="KTP Preview" style="max-width: 100px;">
                        @else
                            <img id="ktp-preview" src="#" alt="KTP Preview" style="max-width: 100px; display: none;">
                        @endif
                        @error('ktp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <label for="npwp" class="col-md-2 col-form-label">{{ __('NPWP') }}</label>
                    <div class="col-md-4">
                        <input id="npwp" type="file" class="form-control @error('npwp') is-invalid @enderror" name="npwp" accept="image/*" onchange="previewFile(this, 'npwp-preview')">
                        @if($wisatawan && $wisatawan->npwp)
                            <img id="npwp-preview" src="{{ asset('storage/'.$wisatawan->npwp) }}" alt="NPWP Preview" style="max-width: 100px;">
                        @else
                            <img id="npwp-preview" src="#" alt="NPWP Preview" style="max-width: 100px; display: none;">
                        @endif
                        @error('npwp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="sim" class="col-md-2 col-form-label">{{ __('SIM') }}</label>
                    <div class="col-md-4">
                        <input id="sim" type="file" class="form-control @error('sim') is-invalid @enderror" name="sim" accept="image/*" onchange="previewFile(this, 'sim-preview')">
                        @if($wisatawan && $wisatawan->sim)
                            <img id="sim-preview" src="{{ asset('storage/'.$wisatawan->sim) }}" alt="SIM Preview" style="max-width: 100px;">
                        @else
                            <img id="sim-preview" src="#" alt="SIM Preview" style="max-width: 100px; display: none;">
                        @endif
                        @error('sim')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary float-end">
                            {{ __('Update Profile') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewFile(input, previewId) {
        var file = input.files[0];
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById(previewId);
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
</script>
@endsection

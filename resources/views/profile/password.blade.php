@extends('layouts.landingpage')

@section('content')
<div class="card border-0 min-vh-100">
    <div class="card-body">
        <div class="container">
            <h2 class="fw-semibold text-center mb-5">Update Password</h2>
        
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
        
                <div class="row mb-3">
                    <label for="current_password" class="col-md-4 col-form-label text-md-end">{{ __('Current Password') }}</label>
                    <div class="col-md-6">
                        <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('New Password') }}</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">{{ __('Confirm New Password') }}</label>
                    <div class="col-md-6">
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>
        
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update Password') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

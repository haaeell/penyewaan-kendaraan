@extends('layouts.dashboard')

@section('content')
<div class="container">
   <div class="card shadow border-0">
    <div class="card-body">
        <h1>{{ isset($promo) ? 'Edit' : 'Tambah' }} Promo</h1>
        <form action="{{ isset($promo) ? route('promos.update', $promo->id) : route('promos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($promo))
                @method('PUT')
            @endif
            <div class="form-group">
                <label for="kode">Kode Promo:</label>
                <input type="text" name="kode" id="kode" class="form-control" value="{{ $promo->kode ?? old('kode') }}" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" required>{{ $promo->deskripsi ?? old('deskripsi') }}</textarea>
            </div>
            <div class="form-group">
                <label for="jenis">Jenis Promo:</label>
                <select name="jenis" id="jenis" class="form-control" required>
                    <option value="diskon_persen" {{ (isset($promo) && $promo->jenis == 'diskon_persen') ? 'selected' : '' }}>Diskon Persen</option>
                    <option value="potongan_harga" {{ (isset($promo) && $promo->jenis == 'potongan_harga') ? 'selected' : '' }}>Potongan Harga</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nilai">Nilai Promo:</label>
                <input type="number" name="nilai" id="nilai" class="form-control" step="0.01" value="{{ $promo->nilai ?? old('nilai') }}" required>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar Promo:</label>
                @if(isset($promo) && $promo->gambar)
                    <img src="{{ $promo->getGambarUrlAttribute() }}" alt="Gambar Promo" width="100" class="mb-2">
                @endif
                <input type="file" name="gambar" id="gambar" class="form-control">
            </div>
            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai:</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="{{ $promo->tanggal_mulai ?? old('tanggal_mulai') }}" required>
            </div>
            <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai:</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="{{ $promo->tanggal_selesai ?? old('tanggal_selesai') }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="1" {{ (isset($promo) && $promo->status) ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ (isset($promo) && !$promo->status) ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3 text-white">{{ isset($promo) ? 'Update' : 'Tambah' }}</button>
        </form>
    </div>
   </div>
</div>
@endsection
